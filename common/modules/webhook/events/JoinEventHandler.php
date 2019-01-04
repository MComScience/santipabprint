<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/11/2561
 * Time: 22:52
 */
namespace common\modules\webhook\events;

use LINE\LINEBot;
use common\modules\webhook\interfaces\EventHandler;
use LINE\LINEBot\Event\JoinEvent;

class JoinEventHandler implements EventHandler
{
    /** @var LINEBot $bot */
    private $bot;
    /** @var \Monolog\Logger $logger */
    private $logger;
    /** @var JoinEvent $joinEvent */
    private $joinEvent;

    /**
     * JoinEventHandler constructor.
     * @param LINEBot $bot
     * @param JoinEvent $joinEvent
     */
    public function __construct($bot, $logger, JoinEvent $joinEvent)
    {
        $this->bot = $bot;
        $this->logger = $logger;
        $this->joinEvent = $joinEvent;
    }

    public function handle()
    {
        if ($this->joinEvent->isGroupEvent()) {
            $id = $this->joinEvent->getGroupId();
        } elseif ($this->joinEvent->isRoomEvent()) {
            $id = $this->joinEvent->getRoomId();
        } else {
            $this->logger->error("Unknown event type");
            return;
        }

        $this->bot->replyText(
            $this->joinEvent->getReplyToken(),
            sprintf('Joined %s %s', $this->joinEvent->getType(), $id)
        );
    }
}