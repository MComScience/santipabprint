<?php

/**
 * Created by PhpStorm.
 * User: Tanakorn Phompak
 * Date: 26/9/2562
 * Time: 23:39
 */

namespace common\modules\webhook\events\messages\flex;

use common\modules\app\models\TblProduct;
use common\modules\webhook\components\BoxComponentBuilder;
use common\modules\webhook\components\BubbleContainerBuilder;
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
use LINE\LINEBot\MessageBuilder\FlexMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\Uri\AltUriBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use yii\helpers\ArrayHelper;

class FlexProduct
{
    const ALT_TEXT = 'สินค้า';

    public static function get($category)
    {
        return self::createFlexBlock($category);
    }

    private static function createFlexBlock($category)
    {
        $flexBlocks = [];
        $contents = [];
        $images = [];
        $texts = [];

        $itemProducts = [];
        $products = TblProduct::find()->where(['product_category_id' => $category['product_category_id']])->orderBy('package_type_id ASC')->all();
        $baseUrl = 'https://santipab.info';
        foreach ($products as $key => $product) {
            $itemProducts[] = [
                'product_id' => $product['product_id'],
                'product_name' => $product['product_name'],
                'product_category_name' => $product->productCategory->product_category_name,
                'product_category_id' => $product->productCategory->product_category_id,
                'image_url' => $baseUrl . $product->getImageUrl(),
            ];
        }

        $total = count($itemProducts);
        foreach ($itemProducts as $key => $item) {
            if ($key + 1 < 80) { // max item limit 80 object
                $product_name = str_replace('/', ',', $item['product_name']);
                $label = $product_name;
                if (mb_strlen($label, 'UTF-8') > 20) {
                    $label = mb_substr($label, 0, 17) . '...';
                }
                $actionUrl = 'https://line.me/R/app/1629709716-kN7qEX7m?catId=' . $item['product_category_id'] . '&productId=' . $item['product_id'];
                $image = self::getImageBuilder($item['image_url'], $actionUrl, $label);
                $text = self::getLabelBuilder($item['product_name'], $label, $actionUrl);
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
                                ->setSize('giga')
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
    }

    public static function createHeaderBlock()
    {
        return BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::HORIZONTAL)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('เลือกสินค้า')
                    ->setSize(ComponentIconSize::LG)
                    ->setWeight(ComponentFontWeight::BOLD)
                    ->setColor('#b5d56a')
            ]);
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
                            'https://line.me/R/app/1629709716-kN7qEX7m'
                        )
                    )
            ]);
    }

    public static function getImageBuilder($imageUrl, $actionUrl, $label)
    {
        return ImageComponentBuilder::builder()
            ->setUrl($imageUrl)
            ->setMargin(ComponentMargin::MD)
            ->setAspectRatio('4:3')
            ->setAspectMode('fit')
            ->setAlign(ComponentAlign::CENTER)
            ->setAction(
                new UriTemplateActionBuilder($label, $actionUrl, new AltUriBuilder($actionUrl))
            );
    }

    public static function getLabelBuilder($text, $label, $actionUrl)
    {
        return TextComponentBuilder::builder()
            ->setText($text)
            ->setSize(ComponentFontSize::XXS)
            ->setAlign(ComponentAlign::CENTER)
            ->setColor('#905c44')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setAction(
                new UriTemplateActionBuilder($label, $actionUrl, new AltUriBuilder($actionUrl))
            );
    }
}