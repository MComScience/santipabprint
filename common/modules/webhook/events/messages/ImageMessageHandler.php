<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/11/2561
 * Time: 22:22
 */
namespace common\modules\webhook\events\messages;

use common\modules\webhook\events\messages\util\UrlBuilder;
use common\modules\webhook\interfaces\EventHandler;
use LINE\LINEBot\Event\MessageEvent\ImageMessage;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use yii\helpers\FileHelper;
use yii\web\Request;

class ImageMessageHandler implements EventHandler
{
    /** @var LINEBot $bot */
    private $bot;
    /** @var \Monolog\Logger $logger */
    private $logger;
    /** @var \yii\web\Request $logger */
    private $req;
    /** @var ImageMessage $imageMessage */
    private $imageMessage;

    /**
     * ImageMessageHandler constructor.
     * @param LINEBot $bot
     * @param \yii\web\Request $req
     * @param ImageMessage $imageMessage
     */
    public function __construct($bot, $logger, Request $req, ImageMessage $imageMessage)
    {
        $this->bot = $bot;
        $this->logger = $logger;
        $this->req = $req;
        $this->imageMessage = $imageMessage;
    }

    public function handle()
    {
        $dir = $_SERVER['DOCUMENT_ROOT'] . '/static/tmpdir';
        $contentId = $this->imageMessage->getMessageId();
        $image = $this->bot->getMessageContent($contentId)->getRawBody();
        $tmpfilePath = tempnam($dir, 'image-');
        if (file_exists($tmpfilePath)){
            FileHelper::unlink($tmpfilePath);
        }
        $filePath = $tmpfilePath . '.jpg';
        $filename = basename($filePath);

        $fh = fopen($filePath, 'x');
        fwrite($fh, $image);
        fclose($fh);

        $replyToken = $this->imageMessage->getReplyToken();

        $url = UrlBuilder::buildUrl($this->req, ['static', 'tmpdir', $filename]);

        // NOTE: You should pass the url of small image to `previewImageUrl`.
        // This sample doesn't treat that.

        $response = $this->bot->replyMessage($replyToken, new ImageMessageBuilder($url, $url));
    }
}