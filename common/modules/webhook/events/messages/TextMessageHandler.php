<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/11/2561
 * Time: 21:25
 */

namespace common\modules\webhook\events\messages;

use common\components\LineBotBuilder;
use common\modules\app\models\TblProduct;
use common\modules\app\models\TblProductCategory;
use common\modules\webhook\events\messages\flex\FlexProduct;
use common\modules\webhook\events\messages\flex\FlexQuotation;
use common\modules\webhook\events\messages\flex\FlexSampleRestaurant;
use common\modules\webhook\events\messages\flex\FlexSampleShopping;
use common\modules\webhook\events\messages\flex\FlexShopping;
use LINE\LINEBot;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder;
use LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder\CameraRollTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\CameraTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\LocationTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\httpclient\Client;
use yii\web\Request;
use common\modules\webhook\interfaces\EventHandler;

class TextMessageHandler implements EventHandler
{
    /** @var LINEBot $bot */
    private $bot;
    /** @var \Monolog\Logger $logger */
    private $logger;
    /** @var yii\web\Request */
    private $req;
    /** @var TextMessage $textMessage */
    private $textMessage;

    public function __construct($bot, $logger, Request $req, TextMessage $textMessage)
    {
        $this->bot = $bot;
        $this->logger = $logger;
        $this->req = $req;
        $this->textMessage = $textMessage;
    }

    public function handle()
    {
        $client = new Client(['baseUrl' => LineBotBuilder::ENDPOINT_BASE]);
        $text = $this->textMessage->getText();
        $replyToken = $this->textMessage->getReplyToken();
        $userId = $this->textMessage->getUserId();
        $this->logger->info("Got text message from $replyToken: $text");
        switch ($text) {
            case 'profile':
                $userId = $this->textMessage->getUserId();
                $this->sendProfile($replyToken, $userId);
                break;
//            case 'tag':
//                return $client->createRequest()
//                    ->setMethod('POST')
//                    ->setUrl('/v2/bot/message/reply')
//                    ->addHeaders([
//                        'Content-Type' => 'application/json',
//                        'Authorization' => 'Bearer ' . LineBotBuilder::ACCESS_TOKEN
//                    ])
//                    ->setContent(Json::encode(['replyToken' => $replyToken, 'messages' => Json::decode($json)]))
//                    ->send();
//                break;
            case 'bye':
                if ($this->textMessage->isRoomEvent()) {
                    $this->bot->replyText($replyToken, 'Leaving room');
                    $this->bot->leaveRoom($this->textMessage->getRoomId());
                    break;
                }
                if ($this->textMessage->isGroupEvent()) {
                    $this->bot->replyText($replyToken, 'Leaving group');
                    $this->bot->leaveGroup($this->textMessage->getGroupId());
                    break;
                }
                $this->bot->replyText($replyToken, 'Bot cannot leave from 1:1 chat');
                break;
            case 'confirm':
                $this->bot->replyMessage(
                    $replyToken,
                    new TemplateMessageBuilder(
                        'Confirm alt text',
                        new ConfirmTemplateBuilder('Do it?', [
                            new MessageTemplateActionBuilder('Yes', 'Yes!'),
                            new MessageTemplateActionBuilder('No', 'No!'),
                        ])
                    )
                );
                break;
            case 'buttons':
                $imageUrl = 'https://nerdist.com/wp-content/uploads/2018/06/One-Piece-906-1.jpg';
                $buttonTemplateBuilder = new ButtonTemplateBuilder(
                    'My button sample',
                    'Hello my button',
                    $imageUrl,
                    [
                        new UriTemplateActionBuilder('Go to line.me', 'https://line.me'),
                        new PostbackTemplateActionBuilder('Buy', 'action=buy&itemid=123'),
                        new PostbackTemplateActionBuilder('Add to cart', 'action=add&itemid=123'),
                        new MessageTemplateActionBuilder('Say message', 'hello hello'),
                    ]
                );
                $templateMessage = new TemplateMessageBuilder('Button alt text', $buttonTemplateBuilder);
                $this->bot->replyMessage($replyToken, $templateMessage);
                break;
            case 'carousel':
                $imageUrl = 'https://nerdist.com/wp-content/uploads/2018/06/One-Piece-906-1.jpg';
                $carouselTemplateBuilder = new CarouselTemplateBuilder([
                    new CarouselColumnTemplateBuilder('foo', 'bar', $imageUrl, [
                        new UriTemplateActionBuilder('Go to line.me', 'https://line.me'),
                        new PostbackTemplateActionBuilder('Buy', 'action=buy&itemid=123'),
                    ]),
                    new CarouselColumnTemplateBuilder('buz', 'qux', $imageUrl, [
                        new PostbackTemplateActionBuilder('Add to cart', 'action=add&itemid=123'),
                        new MessageTemplateActionBuilder('Say message', 'hello hello'),
                    ]),
                ]);
                $templateMessage = new TemplateMessageBuilder('Button alt text', $carouselTemplateBuilder);
                $this->bot->replyMessage($replyToken, $templateMessage);
                break;
            case 'image-map':
                $richMessageUrl = '';
                $imagemapMessageBuilder = new ImagemapMessageBuilder(
                    $richMessageUrl,
                    'This is alt text',
                    new BaseSizeBuilder(1040, 1040),
                    [
                        new ImagemapUriActionBuilder(
                            'https://store.line.me/family/manga/en',
                            new AreaBuilder(0, 0, 520, 520)
                        ),
                        new ImagemapUriActionBuilder(
                            'https://store.line.me/family/music/en',
                            new AreaBuilder(520, 0, 520, 520)
                        ),
                        new ImagemapUriActionBuilder(
                            'https://store.line.me/family/play/en',
                            new AreaBuilder(0, 520, 520, 520)
                        ),
                        new ImagemapMessageActionBuilder(
                            'URANAI!',
                            new AreaBuilder(520, 520, 520, 520)
                        )
                    ]
                );
                $this->bot->replyMessage($replyToken, $imagemapMessageBuilder);
                break;
            case 'restaurant':
                $flexMessageBuilder = FlexSampleRestaurant::get();
                $this->bot->replyMessage($replyToken, $flexMessageBuilder);
                break;
            case 'flex1':
                $flexMessageBuilder = FlexQuotation::get();
                $this->bot->replyMessage($replyToken, $flexMessageBuilder);
                break;
            case 'ขอใบเสนอราคา':
                $flexMessageBuilder = FlexShopping::get();
                return $client->createRequest()
                    ->setMethod('POST')
                    ->setUrl('/v2/bot/message/reply')
                    ->addHeaders([
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . LineBotBuilder::ACCESS_TOKEN
                    ])
                    ->setContent(Json::encode(['replyToken' => $replyToken, 'messages' => $flexMessageBuilder], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE))
                    ->send();
                break;
            case 'shopping':
                $flexMessageBuilder = FlexSampleShopping::get();
                $this->bot->replyMessage($replyToken, $flexMessageBuilder);
                break;
            case 'quickReply':
                $postback = new PostbackTemplateActionBuilder('Buy', 'action=quickBuy&itemid=222', 'Buy');
                $datetimePicker = new DatetimePickerTemplateActionBuilder(
                    'Select date',
                    'storeId=12345',
                    'datetime',
                    '2017-12-25t00:00',
                    '2018-01-24t23:59',
                    '2017-12-25t00:00'
                );

                $quickReply = new QuickReplyMessageBuilder([
                    new QuickReplyButtonBuilder(new LocationTemplateActionBuilder('Location')),
                    new QuickReplyButtonBuilder(new CameraTemplateActionBuilder('Camera')),
                    new QuickReplyButtonBuilder(new CameraRollTemplateActionBuilder('Camera roll')),
                    new QuickReplyButtonBuilder($postback),
                    new QuickReplyButtonBuilder($datetimePicker),
                ]);

                $messageTemplate = new TextMessageBuilder('Text with quickReply buttons', $quickReply);
                $this->bot->replyMessage($replyToken, $messageTemplate);
                break;
            default:
                $this->echoBack($replyToken, $text);
                break;
        }
    }

    /**
     * @param string $replyToken
     * @param string $text
     */
    private function echoBack($replyToken, $text)
    {
        $client = new Client(['baseUrl' => LineBotBuilder::ENDPOINT_BASE]);
        $categorys = TblProductCategory::find()->all();
        $keywords = ArrayHelper::getColumn($categorys, 'product_category_name');
        if (ArrayHelper::isIn($text, $keywords)) {
            $category = TblProductCategory::findOne(['product_category_name' => $text]);
            if ($category) {
                $flexMessageBuilder = FlexProduct::get($category);
                if ($flexMessageBuilder) {
                    return $client->createRequest()
                        ->setMethod('POST')
                        ->setUrl('/v2/bot/message/reply')
                        ->addHeaders([
                            'Content-Type' => 'application/json',
                            'Authorization' => 'Bearer ' . LineBotBuilder::ACCESS_TOKEN
                        ])
                        ->setContent(Json::encode(['replyToken' => $replyToken, 'messages' => $flexMessageBuilder], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE))
                        ->send();
                }
            }
        } else {
            $this->bot->replyText($replyToken, $text);
        }
        $this->logger->info("Returns echo message $replyToken: $text");
    }

    private function sendProfile($replyToken, $userId)
    {
        if (!isset($userId)) {
            $this->bot->replyText($replyToken, "Bot can't use profile API without user ID");
            return;
        }

        $response = $this->bot->getProfile($userId);
        if (!$response->isSucceeded()) {
            $this->bot->replyText($replyToken, $response->getRawBody());
            return;
        }

        $profile = $response->getJSONDecodedBody();
        $statusMessage = (ArrayHelper::keyExists('username', $profile, false) ? $profile['statusMessage'] : '');
        $this->bot->replyText(
            $replyToken,
            'Display name: ' . $profile['displayName'],
            'Status message: ' . $statusMessage
        );
    }
}