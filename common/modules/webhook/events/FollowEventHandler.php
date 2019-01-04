<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/11/2561
 * Time: 22:49
 */
namespace common\modules\webhook\events;

use LINE\LINEBot;
use common\modules\webhook\interfaces\EventHandler;
use LINE\LINEBot\Event\FollowEvent;

class FollowEventHandler implements EventHandler
{
    /** @var LINEBot $bot */
    private $bot;
    /** @var \Monolog\Logger $logger */
    private $logger;
    /** @var FollowEvent $followEvent */
    private $followEvent;

    /**
     * FollowEventHandler constructor.
     * @param LINEBot $bot
     * @param FollowEvent $followEvent
     */
    public function __construct($bot, $logger, FollowEvent $followEvent)
    {
        $this->bot = $bot;
        $this->logger = $logger;
        $this->followEvent = $followEvent;
    }

    public function handle()
    {
        $this->bot->replyText($this->followEvent->getReplyToken(), 'Got followed event');
    }
}