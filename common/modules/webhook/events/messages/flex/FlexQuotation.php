<?php

namespace common\modules\webhook\events\messages\flex;

use LINE\LINEBot\Constant\Flex\ComponentAlign;
use LINE\LINEBot\Constant\Flex\ComponentButtonHeight;
use LINE\LINEBot\Constant\Flex\ComponentButtonStyle;
use LINE\LINEBot\Constant\Flex\ComponentFontSize;
use LINE\LINEBot\Constant\Flex\ComponentFontWeight;
use LINE\LINEBot\Constant\Flex\ComponentGravity;
use LINE\LINEBot\Constant\Flex\ComponentIconSize;
use LINE\LINEBot\Constant\Flex\ComponentImageAspectMode;
use LINE\LINEBot\Constant\Flex\ComponentImageAspectRatio;
use LINE\LINEBot\Constant\Flex\ComponentImageSize;
use LINE\LINEBot\Constant\Flex\ComponentLayout;
use LINE\LINEBot\Constant\Flex\ComponentMargin;
use LINE\LINEBot\Constant\Flex\ComponentSpaceSize;
use LINE\LINEBot\Constant\Flex\ComponentSpacing;
use LINE\LINEBot\MessageBuilder\Flex\BlockStyleBuilder;
use LINE\LINEBot\MessageBuilder\Flex\BubbleStylesBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ButtonComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\IconComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ImageComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\SeparatorComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\SpacerComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\BubbleContainerBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\CarouselContainerBuilder;
use LINE\LINEBot\MessageBuilder\FlexMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: Tanakorn Phompak
 * Date: 23/9/2562
 * Time: 19:35
 */
class FlexQuotation
{
    private static $items = [
        [
            'text' => 'ขนาด',
            'value' => '5.8 นิ้ว'
        ],
        [
            'text' => 'กระดาษ',
            'value' => 'อาร์ตการ์ดสองหน้า 300 แกรม'
        ],
        [
            'text' => 'พิมพ์',
            'value' => 'พิมพ์สองหน้า พิมพ์ 2 สี'
        ],
        [
            'text' => 'เคลือบ',
            'value' => 'เคลือบ pvc ด้าน (เคลือบสองด้าน)'
        ],
        [
            'text' => 'ไดคัท',
            'value' => 'ไดคัมตามรูปแบบ'
        ],
        [
            'text' => 'ฟอยล์',
            'value' => 'ไม่ปั๊มฟอยล์'
        ],
        [
            'text' => 'ปั๊มนูน',
            'value' => 'ไม่ปั๊มนูน'
        ],
    ];

    public static function get()
    {
        return FlexMessageBuilder::builder()
            ->setAltText('ใบเสนอราคา')
            ->setContents(
                BubbleContainerBuilder::builder()
                    ->setStyles(
                        BubbleStylesBuilder::builder()
                            ->setFooter(BlockStyleBuilder::builder()->setSeparator(true))
                    )
                    ->setHero(self::createHeroBlock())
                    ->setBody(self::createBodyBlock())
                    ->setFooter(self::createFooterBlock())
            );
    }

    private static function createHeroBlock()
    {
        return ImageComponentBuilder::builder()
            ->setUrl('https://santipab.info/uploads/1/YKZPT0ynNZBqRmIssFy39X1kaD5Fmziv.jpg')
            ->setSize(ComponentImageSize::FULL)
            ->setAspectRatio(ComponentImageAspectRatio::R20TO13)
            ->setAspectMode(ComponentImageAspectMode::COVER)
            ->setAction(new UriTemplateActionBuilder(null, 'https://santipab.info/uploads/1/YKZPT0ynNZBqRmIssFy39X1kaD5Fmziv.jpg'));
    }

    private static function createBodyBlock()
    {
        $items = self::$items;
        $title = TextComponentBuilder::builder()
            ->setText('รายละเอียดใบเสนอราคา')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setColor('#1DB446')
            ->setSize(ComponentFontSize::SM)
            ->setAlign(ComponentAlign::START);

        $productName = TextComponentBuilder::builder()
            ->setText('นามบัตร/บัตรสะสมแต้ม')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::XS)
            ->setMargin(ComponentMargin::MD);

        $separator = SeparatorComponentBuilder::builder()
            ->setMargin(ComponentMargin::XXL);

        $boxItems = [];
        foreach ($items as $key => $item) {
            $itemStart = TextComponentBuilder::builder()
                ->setText($item['text'])
                ->setSize(ComponentIconSize::XS)
                ->setColor('#555555')
                ->setAlign(ComponentAlign::START);

            $itemEnd = TextComponentBuilder::builder()
                ->setText($item['value'])
                ->setSize(ComponentIconSize::XS)
                ->setColor('#111111')
                ->setAlign(ComponentAlign::END);

            $boxItems = ArrayHelper::merge($boxItems, [
                BoxComponentBuilder::builder()
                    ->setLayout(ComponentLayout::HORIZONTAL)
                    ->setMargin(ComponentMargin::MD)
                    ->setContents([
                        $itemStart,
                        $itemEnd
                    ])
            ]);
        }

        $boxID = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::HORIZONTAL)
            ->setMargin(ComponentMargin::MD)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('ID')
                    ->setSize(ComponentIconSize::XS)
                    ->setColor('#aaaaaa')
                    ->setAlign(ComponentAlign::START),
                TextComponentBuilder::builder()
                    ->setText('#743289384279')
                    ->setSize(ComponentIconSize::XS)
                    ->setColor('#aaaaaa')
                    ->setAlign(ComponentAlign::END)
            ]);

        $boxDetail = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setMargin(ComponentMargin::XXL)
            ->setSpacing(ComponentSpacing::SM)
            ->setContents(ArrayHelper::merge([
                $boxID
            ], $boxItems));

        $boxQty = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::HORIZONTAL)
            ->setMargin(ComponentMargin::MD)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('จำนวน')
                    ->setSize(ComponentIconSize::MD)
                    ->setColor('#ea7066')
                    ->setAlign(ComponentAlign::START),
                TextComponentBuilder::builder()
                    ->setText('2,000 ชิ้น')
                    ->setSize(ComponentIconSize::XS)
                    ->setColor('#ea7066')
                    ->setAlign(ComponentAlign::END)
            ]);

        $boxPrice = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::HORIZONTAL)
            ->setMargin(ComponentMargin::MD)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('ราคา')
                    ->setSize(ComponentIconSize::MD)
                    ->setColor('#ea7066')
                    ->setAlign(ComponentAlign::START),
                TextComponentBuilder::builder()
                    ->setText('15,000 บาท')
                    ->setSize(ComponentIconSize::XS)
                    ->setColor('#ea7066')
                    ->setAlign(ComponentAlign::END)
            ]);

        return BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setContents([$title, $productName, $separator, $boxDetail, $separator, $boxQty, $boxPrice]);
    }

    private static function createFooterBlock()
    {
        $callButton = ButtonComponentBuilder::builder()
            ->setColor('#905c44')
            // ->setStyle(ComponentButtonStyle::LINK)
            ->setHeight(ComponentButtonHeight::SM)
            ->setAction(new UriTemplateActionBuilder('ดาวน์โหลดใบเสนอราคา', 'https://example.com'));
        $spacer = new SpacerComponentBuilder(ComponentSpaceSize::SM);

        return BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setSpacing(ComponentSpacing::SM)
            ->setFlex(0)
            ->setContents([$callButton, $spacer]);
    }
}