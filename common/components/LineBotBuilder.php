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

    public $channelSecret = 'e7ea194db06c7d844d24505ed3e2a916';

    private $_httpClient;

    private $_bot;

    const ENDPOINT_BASE = 'https://api.line.me';

    const ACCESS_TOKEN = '1t6nQ9r4R9DQvdMttAeM8RO11d+RuhC1cLvg0jtY+5AcItMSGuyK62RtUpm9zZl55WXKi9NSuqHdj5uzi+hHKwrJPeOzDiNIuqlMwICmkH9p1e4cYuvX/S48wqc7svlTSQgvdunNelC9+wuLFwhnEQdB04t89/1O/w1cDnyilFU=';

    public function init()
    {
        parent::init();
//        if ($this->access_token == null) {
//            $this->access_token = '1t6nQ9r4R9DQvdMttAeM8RO11d+RuhC1cLvg0jtY+5AcItMSGuyK62RtUpm9zZl55WXKi9NSuqHdj5uzi+hHKwrJPeOzDiNIuqlMwICmkH9p1e4cYuvX/S48wqc7svlTSQgvdunNelC9+wuLFwhnEQdB04t89/1O/w1cDnyilFU=';
//        }
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
        $this->_httpClient = new CurlHTTPClient(self::ACCESS_TOKEN);
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

    public static function getAccessToken()
    {
        return self::ACCESS_TOKEN;
    }
}