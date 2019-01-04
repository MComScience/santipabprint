<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/11/2561
 * Time: 22:27
 */

namespace common\modules\webhook\events\messages;

use common\modules\webhook\events\messages\util\UrlBuilder;
use common\modules\webhook\interfaces\EventHandler;
use LINE\LINEBot\Event\MessageEvent\AudioMessage;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use yii\helpers\FileHelper;
use yii\web\Request;

class AudioMessageHandler implements EventHandler
{
    /** @var LINEBot $bot */
    private $bot;
    /** @var \Monolog\Logger $logger */
    private $logger;
    /** @var \yii\web\Request $logger */
    private $req;
    /** @var AudioMessage $audioMessage */
    private $audioMessage;

    /**
     * AudioMessageHandler constructor.
     * @param LINEBot $bot
     * @param \yii\web\Request $req
     * @param AudioMessage $audioMessage
     */
    public function __construct($bot, $logger, Request $req, AudioMessage $audioMessage)
    {
        $this->bot = $bot;
        $this->logger = $logger;
        $this->req = $req;
        $this->audioMessage = $audioMessage;
    }

    public function handle()
    {
        $dir = $_SERVER['DOCUMENT_ROOT'] . '/static/tmpdir';
        $contentId = $this->audioMessage->getMessageId();
        $audio = $this->bot->getMessageContent($contentId)->getRawBody();

        $tmpfilePath = tempnam($dir, 'audio-');
        if (file_exists($tmpfilePath)){
            FileHelper::unlink($tmpfilePath);
        }
        $filePath = $tmpfilePath . '.mp4';
        $filename = basename($filePath);

        $fh = fopen($filePath, 'x');
        fwrite($fh, $audio);
        fclose($fh);

        $replyToken = $this->audioMessage->getReplyToken();

        $url = UrlBuilder::buildUrl($this->req, ['static', 'tmpdir', $filename]);

        $resp = $this->bot->replyMessage(
            $replyToken,
            new AudioMessageBuilder($url, 100)
        );
    }
}