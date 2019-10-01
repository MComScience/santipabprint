<?php

namespace common\modules\webhook\controllers;

use common\components\Logger;
use common\modules\webhook\events\AccountLinkEventHandler;
use common\modules\webhook\events\BeaconEventHandler;
use common\modules\webhook\events\FollowEventHandler;
use common\modules\webhook\events\JoinEventHandler;
use common\modules\webhook\events\LeaveEventHandler;
use common\modules\webhook\events\PostbackEventHandler;
use common\modules\webhook\events\UnfollowEventHandler;
use LINE\LINEBot\Event\AccountLinkEvent;
use LINE\LINEBot\Event\BeaconDetectionEvent;
use LINE\LINEBot\Event\FollowEvent;
use LINE\LINEBot\Event\JoinEvent;
use LINE\LINEBot\Event\LeaveEvent;
use LINE\LINEBot\Event\MessageEvent\AudioMessage;
use LINE\LINEBot\Event\MessageEvent\ImageMessage;
use LINE\LINEBot\Event\MessageEvent\LocationMessage;
use LINE\LINEBot\Event\MessageEvent\UnknownMessage;
use LINE\LINEBot\Event\MessageEvent\VideoMessage;
use LINE\LINEBot\Event\PostbackEvent;
use LINE\LINEBot\Event\UnfollowEvent;
use LINE\LINEBot\Event\UnknownEvent;
use Yii;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use LINE\LINEBot\Event\MessageEvent;
use common\components\LineBotBuilder;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\Event\MessageEvent\StickerMessage;
use LINE\LINEBot\Exception\InvalidSignatureException;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use common\modules\webhook\events\messages\TextMessageHandler;
use common\modules\webhook\events\messages\StickerMessageHandler;
use common\modules\webhook\events\messages\LocationMessageHandler;
use common\modules\webhook\events\messages\ImageMessageHandler;
use common\modules\webhook\events\messages\AudioMessageHandler;
use common\modules\webhook\events\messages\VideoMessageHandler;
use LINE\LINEBot\KitchenSink\EventHandler;

class LineController extends \yii\web\Controller
{
    const LINE_SIGNATURE = 'X-Line-Signature';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'callback' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == 'callback') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    // webhook callback
    public function actionCallback()
    {
        $request = Yii::$app->getRequest();
        $headers = $request->headers;
        $signature = $headers->get(self::LINE_SIGNATURE);
        $logger = new Logger();
        $logger = $logger->getLogger();
        if (empty($signature)) {
            $logger->info('Signature is missing');
            throw new HttpException(400, 'Bad Request');
        }
        $line = new LineBotBuilder();
        $bot = $line->bot;
        try {
            $events = $bot->parseEventRequest($request->getRawBody(), $signature);
        } catch (InvalidSignatureException $e) {
            $logger->info('Invalid signature');
            throw new HttpException(400, $e->getMessage());
        } catch (InvalidEventRequestException $e) {
            throw new HttpException(400, $e->getMessage());
        }

        foreach ($events as $event) {
            /** @var EventHandler $handler */
            $handler = null;
            if ($event instanceof MessageEvent) {
                if ($event instanceof TextMessage) {
                    $handler = new TextMessageHandler($bot, $logger, $request, $event);
                } elseif ($event instanceof StickerMessage) {
                    $handler = new StickerMessageHandler($bot, $logger, $event);
                } elseif ($event instanceof LocationMessage) {
                    $handler = new LocationMessageHandler($bot, $logger, $event);
                } elseif ($event instanceof ImageMessage) {
                    $handler = new ImageMessageHandler($bot, $logger, $request, $event);
                } elseif ($event instanceof AudioMessage) {
                    $handler = new AudioMessageHandler($bot, $logger, $request, $event);
                } elseif ($event instanceof VideoMessage) {
                    $handler = new VideoMessageHandler($bot, $logger, $request, $event);
                } elseif ($event instanceof UnknownMessage) {
                    $logger->info(sprintf(
                        'Unknown message type has come [message type: %s]',
                        $event->getMessageType()
                    ));
                } else {
                    // Unexpected behavior (just in case)
                    // something wrong if reach here
                    $logger->info(sprintf(
                        'Unexpected message type has come, something wrong [class name: %s]',
                        get_class($event)
                    ));
                    continue;
                }
            } elseif ($event instanceof UnfollowEvent) {
                $handler = new UnfollowEventHandler($bot, $logger, $event);
            } elseif ($event instanceof FollowEvent) {
                $handler = new FollowEventHandler($bot, $logger, $event);
            } elseif ($event instanceof JoinEvent) {
                $handler = new JoinEventHandler($bot, $logger, $event);
            } elseif ($event instanceof LeaveEvent) {
                $handler = new LeaveEventHandler($bot, $logger, $event);
            } elseif ($event instanceof PostbackEvent) {
                $handler = new PostbackEventHandler($bot, $logger, $event);
            } elseif ($event instanceof BeaconDetectionEvent) {
                $handler = new BeaconEventHandler($bot, $logger, $event);
            } elseif ($event instanceof AccountLinkEvent) {
                $handler = new AccountLinkEventHandler($bot, $logger, $event);
            } elseif ($event instanceof UnknownEvent) {
                $logger->info(sprintf('Unknown message type has come [type: %s]', $event->getType()));
            } else {
                // Unexpected behavior (just in case)
                // something wrong if reach here
                $logger->info(sprintf(
                    'Unexpected event type has come, something wrong [class name: %s]',
                    get_class($event)
                ));
                continue;
            }
            $handler->handle();
            return 'OK';
        }
    }
}
