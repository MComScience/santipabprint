<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/11/2561
 * Time: 21:25
 */

namespace common\modules\webhook\events\messages;

use common\modules\webhook\events\messages\flex\FlexSampleRestaurant;
use common\modules\webhook\events\messages\flex\FlexSampleShopping;
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
        $json = '[
  {
    "type": "flex",
    "altText": "ใบเสนอราคา",
    "contents": {
      "type": "bubble",
      "styles": {
        "footer": {
          "separator": true
        }
      },
      "body": {
        "type": "box",
        "layout": "vertical",
        "contents": [
          {
            "type": "text",
            "text": "รายละเอียดใบเสนอราคา",
            "weight": "bold",
            "color": "#1DB446",
            "size": "sm",
            "align": "center"
          },
          {
            "type": "text",
            "text": "นามบัตร/บัตรสะสมแต้ม",
            "weight": "bold",
            "size": "md",
            "margin": "md"
          },
          {
            "type": "separator",
            "margin": "xxl"
          },
          {
            "type": "box",
            "layout": "vertical",
            "margin": "xxl",
            "spacing": "sm",
            "contents": [
              {
                "type": "box",
                "layout": "horizontal",
                "contents": [
                  {
                    "type": "text",
                    "text": "ขนาด",
                    "size": "sm",
                    "color": "#555555",
                    "flex": 0
                  },
                  {
                    "type": "text",
                    "text": "5*8 นิ้ว",
                    "size": "sm",
                    "color": "#111111",
                    "align": "end"
                  }
                ]
              },
              {
                "type": "box",
                "layout": "horizontal",
                "contents": [
                  {
                    "type": "text",
                    "text": "กระดาษ",
                    "size": "sm",
                    "color": "#555555",
                    "flex": 0
                  },
                  {
                    "type": "text",
                    "text": "อาร์ตการ์ดสองหน้า 300 แกรม",
                    "size": "sm",
                    "color": "#111111",
                    "align": "end"
                  }
                ]
              },
              {
                "type": "box",
                "layout": "horizontal",
                "contents": [
                  {
                    "type": "text",
                    "text": "พิมพ์",
                    "size": "sm",
                    "color": "#555555",
                    "flex": 0
                  },
                  {
                    "type": "text",
                    "text": "พิมพ์สองหน้า พิมพ์ 2 สี",
                    "size": "sm",
                    "color": "#111111",
                    "align": "end"
                  }
                ]
              },
              {
                "type": "box",
                "layout": "horizontal",
                "contents": [
                  {
                    "type": "text",
                    "text": "เคลือบ",
                    "size": "sm",
                    "color": "#555555",
                    "flex": 0
                  },
                  {
                    "type": "text",
                    "text": "เคลือบ pvc ด้าน สองด้าน",
                    "size": "sm",
                    "color": "#111111",
                    "align": "end"
                  }
                ]
              },
              {
                "type": "box",
                "layout": "horizontal",
                "contents": [
                  {
                    "type": "text",
                    "text": "ไดคัท",
                    "size": "sm",
                    "color": "#555555",
                    "flex": 0
                  },
                  {
                    "type": "text",
                    "text": "ไดคัทตามรูปแบบ",
                    "size": "sm",
                    "color": "#111111",
                    "align": "end"
                  }
                ]
              },
              {
                "type": "box",
                "layout": "horizontal",
                "contents": [
                  {
                    "type": "text",
                    "text": "ฟอยล์",
                    "size": "sm",
                    "color": "#555555",
                    "flex": 0
                  },
                  {
                    "type": "text",
                    "text": "ไม่ปั๊มฟอยล์",
                    "size": "sm",
                    "color": "#111111",
                    "align": "end"
                  }
                ]
              },
              {
                "type": "box",
                "layout": "horizontal",
                "contents": [
                  {
                    "type": "text",
                    "text": "ปั๊มนูน",
                    "size": "sm",
                    "color": "#555555",
                    "flex": 0
                  },
                  {
                    "type": "text",
                    "text": "ไม่ปั๊มนูน",
                    "size": "sm",
                    "color": "#111111",
                    "align": "end"
                  }
                ]
              }
            ]
          },
          {
            "type": "separator",
            "margin": "xxl"
          },
          {
            "type": "box",
            "layout": "horizontal",
            "margin": "md",
            "contents": [
              {
                "type": "text",
                "text": "จำนวน",
                "size": "md",
                "color": "#ea7066",
                "flex": 0
              },
              {
                "type": "text",
                "text": "2000 ชิ้น",
                "color": "#ea7066",
                "size": "md",
                "align": "end"
              }
            ]
          },
          {
            "type": "box",
            "layout": "horizontal",
            "margin": "md",
            "contents": [
              {
                "type": "text",
                "text": "ราคา",
                "size": "md",
                "color": "#ea7066",
                "flex": 0
              },
              {
                "type": "text",
                "text": "15,000฿",
                "color": "#ea7066",
                "size": "md",
                "align": "end"
              }
            ]
          },
          {
            "type": "box",
            "layout": "horizontal",
            "margin": "md",
            "contents": [
              {
                "type": "text",
                "text": "ID",
                "size": "xs",
                "color": "#aaaaaa",
                "flex": 0
              },
              {
                "type": "text",
                "text": "#743289384279",
                "color": "#aaaaaa",
                "size": "xs",
                "align": "end"
              }
            ]
          }
        ]
      }
    }
  }
]';
        $text = $this->textMessage->getText();
        $replyToken = $this->textMessage->getReplyToken();
        $this->logger->info("Got text message from $replyToken: $text");
        switch ($text) {
            case 'profile':
                $userId = $this->textMessage->getUserId();
                $this->sendProfile($replyToken, $userId);
                break;
            case 'tag':
                $userId = $this->textMessage->getUserId();
                $this->bot->replyText($replyToken, \yii\helpers\Json::decode($json));
                break;
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
        $this->logger->info("Returns echo message $replyToken: $text");
        $this->bot->replyText($replyToken, $text);
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