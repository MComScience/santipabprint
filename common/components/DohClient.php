<?php

namespace common\components;

use yii\authclient\OAuth2;
use dektrium\user\clients\ClientInterface;

class DohClient extends OAuth2 implements ClientInterface
{
    public $authUrl = 'http://yii2-sso.local/oauth2/authorize/index';

    public $tokenUrl = 'http://yii2-sso.local/oauth2/token/index';

    public $apiBaseUrl = 'http://yii2-sso.local/api/v1';

    public $attributeNames = [
        'email',
        'username'
    ];

    protected function defaultName()
    {
        return 'doh';
    }

    protected function defaultTitle()
    {
        return 'DOH';
    }

    protected function defaultViewOptions()
    {
        return [
            'popupWidth' => 500,
            'popupHeight' => 500,
        ];
    }

    protected function initUserAttributes()
    {
        return $this->api('user/info', 'GET');
    }

    public function applyAccessTokenToRequest($request, $accessToken)
    {
        $data = $request->getData();
        $data['access-token'] = $accessToken->getToken();
        $request->setData($data);
    }

        /** @inheritdoc */
    public function getEmail()
    {
        return isset($this->getUserAttributes()['email'])
            ? $this->getUserAttributes()['email']
            : null;
    }
    /** @inheritdoc */
    public function getUsername()
    {
        return isset($this->getUserAttributes()['username'])
            ? $this->getUserAttributes()['username']
            : null;
    }
}
