<?php

/**
 * Created by PhpStorm.
 * User: Tanakorn Phompak
 * Date: 21/10/2562
 * Time: 20:24
 */

namespace common\traits;

use Firebase\JWT\JWT;
use Yii;
use yii\web\Request as WebRequest;

trait UserJwt
{
    /** @var  string to store JSON web token */
    public $access_token;
    /**
     * Store JWT token header items.
     * @var array
     */
    protected static $decodedToken;

    /**
     * Getter for secret key that's used for generation of JWT
     * @return string secret key used to generate JWT
     */
    protected static function getSecretKey()
    {
        return isset(Yii::$app->params['secretKey']) ? Yii::$app->params['secretKey'] : 'jwtSecretCode';
    }

    /**
     * Getter for expIn token that's used for generation of JWT
     * @return integer time to add expIn token used to generate JWT
     */
    protected static function getExpireIn()
    {
        return isset(Yii::$app->params['expiresIn']) ? strtotime(Yii::$app->params['expiresIn']) : 0;
    }

    /**
     * Getter for "header" array that's used for generation of JWT
     * @return array JWT Header Token param, see http://jwt.io/ for details
     */
    protected static function getHeaderToken()
    {
        return [];
    }

    /**
     * Getter for encryption algorytm used in JWT generation and decoding
     * Override this method to set up other algorytm.
     * @return string needed algorytm
     */
    public static function getAlgo()
    {
        return 'HS256';
    }

    /**
     * Logins user by given JWT encoded string. If string is correctly decoded
     * - array (token) must contain 'jti' param - the id of existing user
     * @param string $accessToken access token to decode
     * @return mixed|null          User model or null if there's no user
     * @throws \yii\web\ForbiddenHttpException if anything went wrong
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = static::findByJTI($token);
        if ($user) {
            return $user;
        }
        $secret = static::getSecretKey();
        // Decode token and transform it into array.
        // Firebase\JWT\JWT throws exception if token can not be decoded
        try {
            JWT::$leeway = 60; // $leeway in seconds
            $decoded = JWT::decode($token, $secret, [static::getAlgo()]);
        } catch (\Exception $e) {
            return false;
        }
        static::$decodedToken = (array)$decoded;
        // If there's no jti param - exception
        if (!isset(static::$decodedToken['jti'])) {
            return false;
        }
        // JTI is unique identifier of user.
        // For more details: https://tools.ietf.org/html/rfc7519#section-4.1.7
        $id = static::$decodedToken['jti'];
        return static::findByJTI($id);
    }

    /**
     * Finds User model using static method findOne
     * Override this method in model if you need to complicate id-management
     * @param string $id if of user to search
     * @return mixed       User model
     */
    public static function findByJTI($token)
    {
        $user = static::findOne(['auth_key' => $token]);
        if ($user !== null && ($user->getIsBlocked() == true || $user->getIsConfirmed() == false)) {
            return null;
        }
        return $user;
    }

    /**
     * Returns some 'id' to encode to token. By default is current model id.
     * If you override this method, be sure that findByJTI is updated too
     * @return integer any unique integer identifier of user
     */
    public function getJTI()
    {
        return $this->getAuthKey();
    }

    /**
     * Encodes model data to create custom JWT with model.id set in it
     * @return string encoded JWT
     */
    public function getJWT()
    {
        // Collect all the data
        $secret = static::getSecretKey();
        $currentTime = time();
        $request = Yii::$app->request;
        $hostInfo = '';
        // There is also a \yii\console\Request that doesn't have this property
        if ($request instanceof WebRequest) {
            $hostInfo = $request->hostInfo;
        }
        // Merge token with presets not to miss any params in custom
        // configuration
        $token = array_merge([
            'iss' => $hostInfo,
            'aud' => $hostInfo,
            'iat' => $currentTime,
            'nbf' => $currentTime,
            'exp' => static::getExpireIn(),
            'data' => [
                'id' => $this->id,
                'username' => $this->username,
                'name' => $this->profile->name,
                'email' => $this->email,
                'confirmed_at' => $this->confirmed_at,
                'unconfirmed_email' => $this->unconfirmed_email,
                'blocked_at' => $this->blocked_at,
                'registration_ip' => $this->registration_ip,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'flags' => $this->flags,
                'last_login_at' => $this->last_login_at
            ]
        ], static::getHeaderToken());
        // Set up id
        $token['jti'] = $this->getJTI();
        return [JWT::encode($token, $secret, static::getAlgo()), $token];
    }

    public function generateAccessTokenAfterUpdatingClientInfo($forceRegenerate = false)
    {
        // update client login
        $this->last_login_at = time();
        // check time is expired or not
        if ($forceRegenerate == true && $this->access_token_expired_at == null || time() > $this->access_token_expired_at) {
            // generate access token
            $this->generateAccessToken();
        } elseif (!$this->access_token) {
            $cache = Yii::$app->cache;
            $access_token = $cache->get($this->getCacheKey());
            if ($access_token === false) {
                $this->generateAccessToken();
            }
            $this->access_token = $cache->get($this->getCacheKey());
        }
        $this->save(false);
        return true;
    }

    public function generateAccessToken()
    {
        // generate access token
        $tokens = $this->getJWT();
        $this->access_token = $tokens[0];   // Token
        $this->access_token_expired_at = $tokens[1]['exp']; // Expire
        // save token to cache
        $cache = Yii::$app->cache;
        $cache->set($this->getCacheKey(), $this->access_token);
    }

    public function getCacheKey()
    {
        return 'u' . $this->getId() . '_access_token';
    }
}