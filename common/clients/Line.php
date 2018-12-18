<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 18/12/2561
 * Time: 10:58
 */
namespace common\clients;

use DomainException;
use Yii;
use yii\authclient\OAuth2;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\HttpException;
use dektrium\user\clients\ClientInterface;

class Line extends OAuth2 implements  ClientInterface
{
    /**
     * {@inheritdoc}
     */
    public $authUrl = 'https://access.line.me/oauth2/v2.1/authorize';
    /**
     * {@inheritdoc}
     */
    public $tokenUrl = 'https://api.line.me/oauth2/v2.1/token';
    /**
     * {@inheritdoc}
     */
    public $apiBaseUrl = 'https://api.line.me';

    private $_playload;

    public function init()
    {
        parent::init();
        if ($this->scope === null) {
            $this->scope = implode(' ', [
                'profile',
                //'openid',
                //'email',
            ]);
        }
    }

    public function getUsername()
    {
        return ArrayHelper::getValue($this->getUserAttributes(), 'email');
    }

    public function getEmail()
    {
        return ArrayHelper::getValue($this->getUserAttributes(), 'email');
    }

    protected function initUserAttributes()
    {
        $token = $this->getAccessToken();
        $attributes = $this->api('v2/profile', 'GET',null,[
            'Authorization' => 'Bearer '.$token->getToken()
        ]);

        if (empty($attributes['email'])) {
            // in case user set 'Keep my email address private' in GitHub profile, email should be retrieved via extra API request
            $scopes = explode(' ', $this->scope);
            if (in_array('email', $scopes, true) || in_array('openid', $scopes, true)) {
                if ($this->_playload && isset($this->_playload['email'])){
                    $attributes['email'] = $this->_playload['email'];
                }else{
                    $attributes['email'] = null;
                }
                $attributes['id'] = $this->_playload['aud'];
            }else{
                $attributes['email'] = null;
            }
        }
        $attributes['id'] = $attributes['userId'];

        return $attributes;
    }

    public function fetchAccessToken($authCode, array $params = [])
    {
        if ($this->validateAuthState) {
            $authState = $this->getState('authState');
            $incomingRequest = Yii::$app->getRequest();
            $incomingState = $incomingRequest->get('state', $incomingRequest->post('state'));
            if (!isset($incomingState) || empty($authState) || strcmp($incomingState, $authState) !== 0) {
                throw new HttpException(400, 'Invalid auth state parameter.');
            }
            $this->removeState('authState');
        }

        $defaultParams = [
            'code' => $authCode,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->getReturnUrl(),
        ];

        $request = $this->createRequest()
            ->setMethod('POST')
            ->setUrl($this->tokenUrl)
            ->setData(array_merge($defaultParams, $params));

        $this->applyClientCredentialsToRequest($request);

        $response = $this->sendRequest($request);

        $scopes = explode(' ', $this->scope);
        if (in_array('email', $scopes, true) || in_array('openid', $scopes, true)) {
            $payload = static::decode($response['id_token']);

            $this->_playload = Json::decode($payload);
        }

        $token = $this->createToken(['params' => $response]);
        $this->setAccessToken($token);

        return $token;
    }

    protected function defaultName()
    {
        return 'line';
    }

    protected function defaultTitle()
    {
        return 'Line';
    }

    protected function defaultViewOptions()
    {
        return [
            'popupWidth' => 800,
            'popupHeight' => 500,
        ];
    }

    public static function decode($id_token)
    {
        $tks = explode('.', $id_token);
        if (count($tks) != 3) {
            throw new \UnexpectedValueException('Wrong number of segments');
        }
        list($headb64, $bodyb64) = $tks;
        if (null === ($header = static::jsonDecode(static::urlsafeB64Decode($headb64)))) {
            throw new \UnexpectedValueException('Invalid header encoding');
        }
        if (null === $payload = static::jsonDecode(static::urlsafeB64Decode($bodyb64))) {
            throw new \UnexpectedValueException('Invalid claims encoding');
        }
        return Json::encode($payload);
    }

    public static function urlsafeB64Decode($input)
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $input .= str_repeat('=', $padlen);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }

    public static function jsonDecode($input)
    {
        if (version_compare(PHP_VERSION, '5.4.0', '>=') && !(defined('JSON_C_VERSION') && PHP_INT_SIZE > 4)) {
            /** In PHP >=5.4.0, json_decode() accepts an options parameter, that allows you
             * to specify that large ints (like Steam Transaction IDs) should be treated as
             * strings, rather than the PHP default behaviour of converting them to floats.
             */
            $obj = json_decode($input, false, 512, JSON_BIGINT_AS_STRING);
        } else {
            /** Not all servers will support that, however, so for older versions we must
             * manually detect large ints in the JSON string and quote them (thus converting
             *them to strings) before decoding, hence the preg_replace() call.
             */
            $max_int_length = strlen((string) PHP_INT_MAX) - 1;
            $json_without_bigints = preg_replace('/:\s*(-?\d{'.$max_int_length.',})/', ': "$1"', $input);
            $obj = json_decode($json_without_bigints);
        }
        if (function_exists('json_last_error') && $errno = json_last_error()) {
            static::handleJsonError($errno);
        } elseif ($obj === null && $input !== 'null') {
            throw new DomainException('Null result with non-null input');
        }
        return $obj;
    }

    private static function handleJsonError($errno)
    {
        $messages = array(
            JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
            JSON_ERROR_STATE_MISMATCH => 'Invalid or malformed JSON',
            JSON_ERROR_CTRL_CHAR => 'Unexpected control character found',
            JSON_ERROR_SYNTAX => 'Syntax error, malformed JSON',
            JSON_ERROR_UTF8 => 'Malformed UTF-8 characters' //PHP >= 5.3.3
        );
        throw new DomainException(
            isset($messages[$errno])
                ? $messages[$errno]
                : 'Unknown JSON error: ' . $errno
        );
    }
}