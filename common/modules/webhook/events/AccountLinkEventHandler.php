<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/11/2561
 * Time: 22:59
 */
namespace common\modules\webhook\events;

use LINE\LINEBot;
use common\modules\webhook\interfaces\EventHandler;
use LINE\LINEBot\Event\AccountLinkEvent;

class AccountLinkEventHandler implements EventHandler
{
    /** @var LINEBot $bot */
    private $bot;
    /** @var \Monolog\Logger $logger */
    private $logger;
    /* @var AccountLinkEvent $accountLinkEvent */
    private $accountLinkEvent;

    /**
     * BeaconEventHandler constructor.
     * @param LINEBot $bot
     * @param \Monolog\Logger $logger
     * @param AccountLinkEvent $accountLinkEvent
     */
    public function __construct($bot, $logger, AccountLinkEvent $accountLinkEvent)
    {
        $this->bot = $bot;
        $this->logger = $logger;
        $this->accountLinkEvent = $accountLinkEvent;
    }

    public function handle()
    {
        $this->bot->replyText(
            $this->accountLinkEvent->getReplyToken(),
            'Got account link event ' . $this->accountLinkEvent->getNonce()
        );
    }
}