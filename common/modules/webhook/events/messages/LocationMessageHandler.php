<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/11/2561
 * Time: 22:19
 */
namespace common\modules\webhook\events\messages;

use common\modules\webhook\interfaces\EventHandler;
use LINE\LINEBot\Event\MessageEvent\LocationMessage;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;

class LocationMessageHandler implements EventHandler
{
    /** @var LINEBot $bot */
    private $bot;
    /** @var \Monolog\Logger $logger */
    private $logger;
    /** @var LocationMessage $event */
    private $locationMessage;

    /**
     * LocationMessageHandler constructor.
     * @param LINEBot $bot
     * @param LocationMessage $locationMessage
     */
    public function __construct($bot, $logger, LocationMessage $locationMessage)
    {
        $this->bot = $bot;
        $this->logger = $logger;
        $this->locationMessage = $locationMessage;
    }

    public function handle()
    {
        $replyToken = $this->locationMessage->getReplyToken();
        $title = $this->locationMessage->getTitle();
        $address = $this->locationMessage->getAddress();
        $latitude = $this->locationMessage->getLatitude();
        $longitude = $this->locationMessage->getLongitude();

        $this->bot->replyMessage(
            $replyToken,
            new LocationMessageBuilder($title, $address, $latitude, $longitude)
        );
    }
}