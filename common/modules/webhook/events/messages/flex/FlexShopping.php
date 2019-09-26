<?php

/**
 * Created by PhpStorm.
 * User: Tanakorn Phompak
 * Date: 26/9/2562
 * Time: 15:10
 */

namespace common\modules\webhook\events\messages\flex;

use common\modules\app\models\TblProductCategory;
use common\modules\webhook\components\BoxComponentBuilder;
use LINE\LINEBot\Constant\Flex\ComponentAlign;
use LINE\LINEBot\Constant\Flex\ComponentButtonHeight;
use LINE\LINEBot\Constant\Flex\ComponentFontSize;
use LINE\LINEBot\Constant\Flex\ComponentFontWeight;
use LINE\LINEBot\Constant\Flex\ComponentIconSize;
use LINE\LINEBot\Constant\Flex\ComponentLayout;
use LINE\LINEBot\Constant\Flex\ComponentMargin;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ButtonComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ImageComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\BubbleContainerBuilder;
use LINE\LINEBot\MessageBuilder\FlexMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class FlexShopping
{
    const ALT_TEXT = 'หมวดหมู่สินค้า';

    public static function get()
    {
        return self::createFlexBlock();
//        return FlexMessageBuilder::builder()
//            ->setAltText(self::ALT_TEXT)
//            ->setContents(
//                BubbleContainerBuilder::builder()
//                    ->setHeader(self::createHeaderBlock())
//                    ->setBody(self::createBodyBlock())
//                    ->setFooter(self::createFooterBlock())
//            );
    }

    public static function createHeaderBlock()
    {
        return BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::HORIZONTAL)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('เลือกหมวดหมู่สินค้า')
                    ->setSize(ComponentIconSize::LG)
                    ->setWeight(ComponentFontWeight::BOLD)
                    ->setColor('#ea7066')
            ]);
    }

    public static function createFlexBlock()
    {
        $flexBlocks = [];
        $contents = [];
        $images = [];
        $texts = [];

        $catagorys = TblProductCategory::find()->all();
        $itemCatagorys = [];
        $baseUrl = 'https://santipab.info';
        foreach ($catagorys as $key => $catagory) {
            $itemCatagorys[] = [
                'product_category_id' => $catagory['product_category_id'],
                'product_category_name' => $catagory['product_category_name'],
                'image_url' => $baseUrl . $catagory->getImageUrl(),
            ];
        }

        $total = count($itemCatagorys);
        foreach ($itemCatagorys as $key => $item) {
            if ($key + 1 < 80) { // max item limit 80 object
                $product_category_name = str_replace('/', ',', $item['product_category_name']);
                $label = $product_category_name;
                if (mb_strlen($label, 'UTF-8') > 20) {
                    $label = mb_substr($label, 0, 17) . '...';
                }
                $image = self::getImageBuilder($item['image_url'], $label, $product_category_name);
                $text = self::getLabelBuilder($item['product_category_name'], $label);
                if (count($images) < 3) {
                    $images = ArrayHelper::merge($images, [$image]);
                }
                if (count($images) == 3 || $key + 1 == $total) {
                    $boxImage = BoxComponentBuilder::builder()
                        ->setLayout(ComponentLayout::HORIZONTAL)
                        ->setContents($images);
                    $contents = ArrayHelper::merge($contents, [$boxImage]);
                    $images = [];
                }
                if (count($texts) < 3) {
                    $texts = ArrayHelper::merge($texts, [$text]);
                }
                if (count($texts) == 3 || $key + 1 == $total) {
                    $boxText = BoxComponentBuilder::builder()
                        ->setLayout(ComponentLayout::HORIZONTAL)
                        ->setContents($texts);
                    $contents = ArrayHelper::merge($contents, [$boxText]);
                    $texts = [];
                }
                if (count($contents) === 10 || $key + 1 == $total) {
                    $flexBuilder = FlexMessageBuilder::builder()
                        ->setAltText(self::ALT_TEXT)
                        ->setContents(
                            BubbleContainerBuilder::builder()
                                ->setHeader(self::createHeaderBlock())
                                ->setBody(
                                    BoxComponentBuilder::builder()
                                    ->setLayout(ComponentLayout::VERTICAL)
                                    ->setContents($contents)
                                    ->setSpacing('md')
                                    ->setBorderColor('#aaaaaa')
                                    ->setBackgroundColor('#f9f9fc')
                                    ->setPaddingTop('20px')
                                    ->setPaddingAll('10px')
                                    ->setPaddingStart('10px')
                                    ->setCornerRadius('md')
                                )
                                ->setFooter(self::createFooterBlock())
                        );
                    $buildMessage = $flexBuilder->buildMessage();
                    $flexBlocks[] = $buildMessage[0];
                    $contents = [];
                }
            }
        }

        return $flexBlocks;
//        return BoxComponentBuilder::builder()
//            ->setLayout(ComponentLayout::VERTICAL)
//            ->setContents($contents)
//            ->setSpacing('md')
//            ->setBorderColor('#aaaaaa')
//            ->setBackgroundColor('#f9f9fc')
//            ->setPaddingTop('20px')
//            ->setPaddingAll('10px')
//            ->setPaddingStart('10px')
//            ->setCornerRadius('md');
    }

    public static function createFooterBlock()
    {
        return BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::HORIZONTAL)
            ->setMargin(ComponentMargin::XS)
            ->setPaddingTop('10px')
            ->setPaddingAll('10px')
            ->setPaddingStart('10px')
            ->setContents([
                ButtonComponentBuilder::builder()
                    ->setColor('#905c44')
                    ->setHeight(ComponentButtonHeight::SM)
                    ->setAction(
                        new UriTemplateActionBuilder(
                            'ดูผลิตภัณฑ์อื่นๆ',
                            'https://line.me/R/app/1583147071-w3v6DmZZ'
                        )
                    )
            ]);
    }

    public static function getImageBuilder($url, $label, $text)
    {
        return ImageComponentBuilder::builder()
            ->setUrl($url)
            ->setMargin(ComponentMargin::MD)
            ->setAspectRatio('4:3')
            ->setAspectMode('fit')
            ->setAlign(ComponentAlign::CENTER)
            ->setAction(
                new MessageTemplateActionBuilder($label, $text)
            );
    }

    public static function getLabelBuilder($text, $label)
    {
        return TextComponentBuilder::builder()
            ->setText($text)
            ->setSize(ComponentFontSize::XXS)
            ->setAlign(ComponentAlign::CENTER)
            ->setColor('#905c44')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setAction(
                new MessageTemplateActionBuilder($label, $text)
            );
    }
}
