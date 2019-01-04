<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/11/2561
 * Time: 22:30
 */
namespace common\modules\webhook\events\messages;

use common\modules\webhook\events\messages\util\UrlBuilder;
use common\modules\webhook\interfaces\EventHandler;
use LINE\LINEBot\Event\MessageEvent\VideoMessage;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use yii\helpers\FileHelper;
use yii\web\Request;

class VideoMessageHandler implements EventHandler
{
    /** @var LINEBot $bot */
    private $bot;
    /** @var \Monolog\Logger $logger */
    private $logger;
    /** @var \yii\web\Request $logger */
    private $req;
    /** @var VideoMessage $videoMessage */
    private $videoMessage;

    /**
     * VideoMessageHandler constructor.
     *
     * @param LINEBot $bot
     * @param \yii\web\Request $req
     * @param VideoMessage $videoMessage
     */
    public function __construct($bot, $logger, Request $req, VideoMessage $videoMessage)
    {
        $this->bot = $bot;
        $this->logger = $logger;
        $this->req = $req;
        $this->videoMessage = $videoMessage;
    }

    public function handle()
    {
        $dir = $_SERVER['DOCUMENT_ROOT'] . '/static/tmpdir';
        $contentId = $this->videoMessage->getMessageId();
        $video = $this->bot->getMessageContent($contentId)->getRawBody();

        $tmpfilePath = tempnam($dir, 'video-');
        if (file_exists($tmpfilePath)){
            FileHelper::unlink($tmpfilePath);
        }
        $filePath = $tmpfilePath . '.mp4';
        $filename = basename($filePath);

        $fh = fopen($filePath, 'x');
        fwrite($fh, $video);
        fclose($fh);

        $replyToken = $this->videoMessage->getReplyToken();

        $url = UrlBuilder::buildUrl($this->req, ['static', 'tmpdir', $filename]);

        // NOTE: You should pass the url of thumbnail image to `previewImageUrl`.
        // This sample doesn't treat that so this sample cannot show the thumbnail.
        $this->bot->replyMessage($replyToken, new VideoMessageBuilder($url, $url));
    }
}