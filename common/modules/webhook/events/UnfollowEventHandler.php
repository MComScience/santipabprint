<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/11/2561
 * Time: 22:34
 */
namespace common\modules\webhook\events;

use LINE\LINEBot;
use common\modules\webhook\interfaces\EventHandler;
use LINE\LINEBot\Event\UnfollowEvent;

class UnfollowEventHandler implements EventHandler
{
    /** @var LINEBot $bot */
    private $bot;
    /** @var \Monolog\Logger $logger */
    private $logger;
    /** @var UnfollowEvent $unfollowEvent */
    private $unfollowEvent;

    /**
     * UnfollowEventHandler constructor.
     * @param LINEBot $bot
     * @param \Monolog\Logger $logger
     * @param UnfollowEvent $unfollowEvent
     */
    public function __construct($bot, $logger, UnfollowEvent $unfollowEvent)
    {
        $this->bot = $bot;
        $this->logger = $logger;
        $this->unfollowEvent = $unfollowEvent;
    }

    public function handle()
    {
        $this->logger->info(sprintf(
            'Unfollowed this bot %s %s',
            $this->unfollowEvent->getType(),
            $this->unfollowEvent->getUserId()
        ));
    }
}