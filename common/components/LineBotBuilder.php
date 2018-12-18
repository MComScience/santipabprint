<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 18/12/2561
 * Time: 13:35
 */
namespace common\components;

use Yii;
use yii\base\Component;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot as BaseLINEBot;

class LineBotBuilder extends Component
{
    public $access_token;

    public $channelSecret = '47bd335446ef3278b98b3e80cfd0d0cb';

    private $_httpClient;

    private $_bot;

    const ENDPOINT_BASE = 'https://api.line.me';

    public function init()
    {
        parent::init();
        if ($this->access_token == null) {
            $this->access_token = 'QA/I2F4zcaQCnx5k7RmUOF/8BCScrjh8pedCOq20IDmIwNqNY7YjmjYQN994sB4ZVYH1ypCp5xPqaLFwY+B6kieGP8CZiFr0Htj50IaT6Wq/fe4qZ3IL6IHr4QEE5l2kxyTcO+n6sQK1D3kK29iYOAdB04t89/1O/w1cDnyilFU=';
        }
        $this->createHttpClient();
    }

    public function getHttpClient()
    {
        if (!is_object($this->_httpClient)) {
            $this->_httpClient = $this->createHttpClient();
        }
        return $this->_httpClient;
    }

    protected function createHttpClient()
    {
        $this->_httpClient = new CurlHTTPClient($this->access_token);
    }

    protected function createBot()
    {
        $this->_bot = new BaseLINEBot($this->_httpClient, [
            'channelSecret' => $this->channelSecret,
            'endpointBase' => self::ENDPOINT_BASE
        ]);
    }

    public function getBot()
    {
        return new BaseLINEBot($this->_httpClient, [
            'channelSecret' => $this->channelSecret,
            'endpointBase' => self::ENDPOINT_BASE
        ]);
    }

    public function getProfile($userId)
    {
        $bot = $this->getBot();
        $response = $bot->getProfile($userId);
        if ($response->isSucceeded()) {
            return $response->getJSONDecodedBody();
        }else{
            throw new \Exception($response->getHTTPStatus() . ' ' . $response->getRawBody());
        }
    }
}