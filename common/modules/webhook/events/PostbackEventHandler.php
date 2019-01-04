<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/11/2561
 * Time: 22:56
 */
namespace common\modules\webhook\events;

use LINE\LINEBot;
use common\modules\webhook\interfaces\EventHandler;
use LINE\LINEBot\Event\PostbackEvent;

class PostbackEventHandler implements EventHandler
{
    /** @var LINEBot $bot */
    private $bot;
    /** @var \Monolog\Logger $logger */
    private $logger;
    /** @var PostbackEvent $postbackEvent */
    private $postbackEvent;

    /**
     * PostbackEventHandler constructor.
     * @param LINEBot $bot
     * @param \Monolog\Logger $logger
     * @param PostbackEvent $postbackEvent
     */
    public function __construct($bot, $logger, PostbackEvent $postbackEvent)
    {
        $this->bot = $bot;
        $this->logger = $logger;
        $this->postbackEvent = $postbackEvent;
    }

    public function handle()
    {
        $this->bot->replyText(
            $this->postbackEvent->getReplyToken(),
            'Got postback ' . $this->postbackEvent->getPostbackData()
        );
    }
}