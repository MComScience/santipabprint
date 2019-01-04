<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/11/2561
 * Time: 22:13
 */
namespace common\modules\webhook\events\messages;

use common\modules\webhook\interfaces\EventHandler;
use LINE\LINEBot\Event\MessageEvent\StickerMessage;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;

class StickerMessageHandler implements EventHandler
{
    /** @var LINEBot $bot */
    private $bot;
    /** @var \Monolog\Logger $logger */
    private $logger;
    /** @var StickerMessage $stickerMessage */
    private $stickerMessage;

    /**
     * StickerMessageHandler constructor.
     * @param LINEBot $bot
     * @param StickerMessage $stickerMessage
     */
    public function __construct($bot, $logger, StickerMessage $stickerMessage)
    {
        $this->bot = $bot;
        $this->logger = $logger;
        $this->stickerMessage = $stickerMessage;
    }


    public function handle()
    {
        $replyToken = $this->stickerMessage->getReplyToken();
        $packageId = $this->stickerMessage->getPackageId();
        $stickerId = $this->stickerMessage->getStickerId();
        $this->bot->replyMessage($replyToken, new StickerMessageBuilder($packageId, $stickerId));
    }
}