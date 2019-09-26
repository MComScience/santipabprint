<?php

namespace common\modules\webhook\events\messages\flex;

use common\modules\webhook\components\BoxComponentBuilder;
use LINE\LINEBot\Constant\Flex\ComponentAlign;
use LINE\LINEBot\Constant\Flex\ComponentFontWeight;
use LINE\LINEBot\Constant\Flex\ComponentIconSize;
use LINE\LINEBot\Constant\Flex\ComponentLayout;
use LINE\LINEBot\Constant\Flex\ComponentSpacing;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\FillerComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\BubbleContainerBuilder;
use LINE\LINEBot\MessageBuilder\FlexMessageBuilder;

/**
 * Created by PhpStorm.
 * User: Tanakorn Phompak
 * Date: 25/9/2562
 * Time: 9:20
 */
class FlexEmsTracking
{
    const ALT_TEXT = 'ติดตามพัสดุ';

    public static function get()
    {
        return FlexMessageBuilder::builder()
            ->setAltText(self::ALT_TEXT)
            ->setContents(
                BubbleContainerBuilder::builder()
                    ->setHeader(self::createHeaderBlock())
                    ->setBody(self::createBodyBlock())
//                    ->setFooter(self::createFooterBlock())
            );
    }

    private static function createHeaderBlock()
    {
        $boxVertical = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('EMS TRACKING')
                    ->setColor('#ffffff66')
                    ->setSize(ComponentIconSize::SM),
                TextComponentBuilder::builder()
                    ->setText('EP881542195TH')
                    ->setColor('#ffffff')
                    ->setSize(ComponentIconSize::XL)
                    ->setFlex(4)
                    ->setWeight(ComponentFontWeight::BOLD)
            ]);
        return BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setContents([$boxVertical])
            ->setPaddingAll('20px')
            ->setBackgroundColor('#0367D3')
            ->setHeight('100px')
            ->setPaddingTop('22px')
            ->setSpacing(ComponentSpacing::MD);
    }

    private static function createBodyBlock()
    {
        $boxContent = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::HORIZONTAL)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('รับเข้าระบบ')
                    ->setSize(ComponentIconSize::XS)
                    ->setGravity('center')
                    ->setColor('#8c8c8c')
                    ->setFlex(4),
                TextComponentBuilder::builder()
                    ->setText('ระหว่างขนส่ง/สถานะ')
                    ->setSize(ComponentIconSize::XS)
                    ->setGravity('center')
                    ->setColor('#8c8c8c')
                    ->setFlex(4)
            ]);

        $boxTime = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::HORIZONTAL)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('11:09')
                    ->setSize(ComponentIconSize::SM)
                    ->setGravity('center')
                    ->setFlex(2),
                BoxComponentBuilder::builder()
                    ->setLayout(ComponentLayout::VERTICAL)
                    ->setContents([
                        FillerComponentBuilder::builder(),
                        BoxComponentBuilder::builder()
                            ->setLayout(ComponentLayout::VERTICAL)
                            ->setContents([FillerComponentBuilder::builder()])
                            ->setCornerRadius('30px')
                            ->setHeight('12px')
                            ->setWidth('12px')
                            ->setBorderColor('#EF454D')
                            ->setBorderWidth('2px'),
                        FillerComponentBuilder::builder()
                    ])
                    ->setFlex(0),
                TextComponentBuilder::builder()
                    ->setText('ดอนเมือง')
                    ->setGravity(ComponentAlign::CENTER)
                    ->setFlex(4)
                    ->setSize(ComponentIconSize::SM)
            ])
            ->setSpacing(ComponentIconSize::LG)
            ->setCornerRadius('30px')
            ->setMargin(ComponentIconSize::XL);

        $boxTimeBaseLine1 = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::HORIZONTAL)
            ->setContents([
                BoxComponentBuilder::builder()
                ->setLayout(ComponentLayout::BASELINE)
                ->setContents([
                    FillerComponentBuilder::builder()
                ])
                ->setFlex(2),
                BoxComponentBuilder::builder()
                    ->setLayout(ComponentLayout::VERTICAL)
                    ->setContents([
                        BoxComponentBuilder::builder()
                            ->setLayout(ComponentLayout::HORIZONTAL)
                            ->setContents([
                                FillerComponentBuilder::builder(),
                                BoxComponentBuilder::builder()
                                ->setLayout(ComponentLayout::VERTICAL)
                                ->setContents([FillerComponentBuilder::builder()])
                                ->setWidth('2px')
                                ->setBackgroundColor('#B7B7B7'),
                                FillerComponentBuilder::builder()
                            ])
                        ->setFlex(1),
                    ])
                    ->setWidth('12px'),
                TextComponentBuilder::builder()
                ->setText('รับฝาก')
                ->setGravity(ComponentAlign::CENTER)
                ->setFlex(4)
                ->setSize(ComponentIconSize::XS)
                ->setColor('#8c8c8c')
            ])
            ->setSpacing(ComponentIconSize::LG)
            ->setHeight('64px');

        $boxTime2 = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::HORIZONTAL)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('17:09')
                    ->setSize(ComponentIconSize::SM)
                    ->setGravity('center')
                    ->setFlex(2),
                BoxComponentBuilder::builder()
                    ->setLayout(ComponentLayout::VERTICAL)
                    ->setContents([
                        FillerComponentBuilder::builder(),
                        BoxComponentBuilder::builder()
                            ->setLayout(ComponentLayout::VERTICAL)
                            ->setContents([FillerComponentBuilder::builder()])
                            ->setCornerRadius('30px')
                            ->setHeight('12px')
                            ->setWidth('12px')
                            ->setBorderColor('#6486E3')
                            ->setBorderWidth('2px'),
                        FillerComponentBuilder::builder()
                    ])
                    ->setFlex(0),
                TextComponentBuilder::builder()
                    ->setText('ดอนเมือง')
                    ->setGravity(ComponentAlign::CENTER)
                    ->setFlex(4)
                    ->setSize(ComponentIconSize::SM)
            ])
            ->setSpacing(ComponentIconSize::LG)
            ->setCornerRadius('30px')
            ->setMargin(ComponentIconSize::XL);
        $boxTimeBaseLine2 = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::HORIZONTAL)
            ->setContents([
                BoxComponentBuilder::builder()
                    ->setLayout(ComponentLayout::BASELINE)
                    ->setContents([
                        FillerComponentBuilder::builder()
                    ])
                    ->setFlex(2),
                BoxComponentBuilder::builder()
                    ->setLayout(ComponentLayout::VERTICAL)
                    ->setContents([
                        BoxComponentBuilder::builder()
                            ->setLayout(ComponentLayout::HORIZONTAL)
                            ->setContents([
                                FillerComponentBuilder::builder(),
                                BoxComponentBuilder::builder()
                                    ->setLayout(ComponentLayout::VERTICAL)
                                    ->setContents([FillerComponentBuilder::builder()])
                                    ->setWidth('2px')
                                    ->setBackgroundColor('#6486E3'),
                                FillerComponentBuilder::builder()
                            ])
                            ->setFlex(1),
                    ])
                    ->setWidth('12px'),
                TextComponentBuilder::builder()
                    ->setText('อยู่ระหว่างการขนส่ง')
                    ->setGravity(ComponentAlign::CENTER)
                    ->setFlex(4)
                    ->setSize(ComponentIconSize::XS)
                    ->setColor('#8c8c8c')
            ])
            ->setSpacing(ComponentIconSize::LG)
            ->setHeight('64px');

        $boxTime3 = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::HORIZONTAL)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('08:55')
                    ->setSize(ComponentIconSize::SM)
                    ->setGravity('center')
                    ->setFlex(2),
                BoxComponentBuilder::builder()
                    ->setLayout(ComponentLayout::VERTICAL)
                    ->setContents([
                        FillerComponentBuilder::builder(),
                        BoxComponentBuilder::builder()
                            ->setLayout(ComponentLayout::VERTICAL)
                            ->setContents([FillerComponentBuilder::builder()])
                            ->setCornerRadius('30px')
                            ->setHeight('12px')
                            ->setWidth('12px')
                            ->setBorderColor('#6486E3')
                            ->setBorderWidth('2px'),
                        FillerComponentBuilder::builder()
                    ])
                    ->setFlex(0),
                TextComponentBuilder::builder()
                    ->setText('หลักสี่')
                    ->setGravity(ComponentAlign::CENTER)
                    ->setFlex(4)
                    ->setSize(ComponentIconSize::SM)
            ])
            ->setSpacing(ComponentIconSize::LG)
            ->setCornerRadius('30px')
            ->setMargin(ComponentIconSize::XL);
        $boxTimeBaseLine3 = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::HORIZONTAL)
            ->setContents([
                BoxComponentBuilder::builder()
                    ->setLayout(ComponentLayout::BASELINE)
                    ->setContents([
                        FillerComponentBuilder::builder()
                    ])
                    ->setFlex(2),
                BoxComponentBuilder::builder()
                    ->setLayout(ComponentLayout::VERTICAL)
                    ->setContents([
                        BoxComponentBuilder::builder()
                            ->setLayout(ComponentLayout::HORIZONTAL)
                            ->setContents([
                                FillerComponentBuilder::builder(),
                                BoxComponentBuilder::builder()
                                    ->setLayout(ComponentLayout::VERTICAL)
                                    ->setContents([FillerComponentBuilder::builder()])
                                    ->setWidth('2px')
                                    ->setBackgroundColor('#6486E3'),
                                FillerComponentBuilder::builder()
                            ])
                            ->setFlex(1),
                    ])
                    ->setWidth('12px'),
                TextComponentBuilder::builder()
                    ->setText('อยู่ระหว่างการนำจ่าย')
                    ->setGravity(ComponentAlign::CENTER)
                    ->setFlex(4)
                    ->setSize(ComponentIconSize::XS)
                    ->setColor('#8c8c8c')
            ])
            ->setSpacing(ComponentIconSize::LG)
            ->setHeight('64px');

        $boxTime4 = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::HORIZONTAL)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('09:00-11:59')
                    ->setSize(ComponentIconSize::SM)
                    ->setGravity('center')
                    ->setFlex(2),
                BoxComponentBuilder::builder()
                    ->setLayout(ComponentLayout::VERTICAL)
                    ->setContents([
                        FillerComponentBuilder::builder(),
                        BoxComponentBuilder::builder()
                            ->setLayout(ComponentLayout::VERTICAL)
                            ->setContents([FillerComponentBuilder::builder()])
                            ->setCornerRadius('30px')
                            ->setHeight('12px')
                            ->setWidth('12px')
                            ->setBorderColor('#42a441')
                            ->setBorderWidth('2px'),
                        FillerComponentBuilder::builder()
                    ])
                    ->setFlex(0),
                TextComponentBuilder::builder()
                    ->setText('หลักสี่')
                    ->setGravity(ComponentAlign::CENTER)
                    ->setFlex(4)
                    ->setSize(ComponentIconSize::SM)
            ])
            ->setSpacing(ComponentIconSize::LG)
            ->setCornerRadius('30px')
            ->setMargin(ComponentIconSize::XL);
        $boxTimeBaseLine4 = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::HORIZONTAL)
            ->setContents([
                BoxComponentBuilder::builder()
                    ->setLayout(ComponentLayout::BASELINE)
                    ->setContents([
                        FillerComponentBuilder::builder()
                    ])
                    ->setFlex(2),
                BoxComponentBuilder::builder()
                    ->setLayout(ComponentLayout::VERTICAL)
                    ->setContents([
                        BoxComponentBuilder::builder()
                            ->setLayout(ComponentLayout::HORIZONTAL)
                            ->setContents([
                                FillerComponentBuilder::builder(),
                                BoxComponentBuilder::builder()
                                    ->setLayout(ComponentLayout::VERTICAL)
                                    ->setContents([FillerComponentBuilder::builder()])
                                    ->setWidth('2px')
                                    ->setBackgroundColor('#42a441'),
                                FillerComponentBuilder::builder()
                            ])
                            ->setFlex(1),
                    ])
                    ->setWidth('12px'),
                TextComponentBuilder::builder()
                    ->setText('นำจ่ายสำเร็จ(22/87)')
                    ->setGravity(ComponentAlign::CENTER)
                    ->setFlex(4)
                    ->setSize(ComponentIconSize::XS)
                    ->setColor('#8c8c8c')
            ])
            ->setSpacing(ComponentIconSize::LG)
            ->setHeight('64px');

        return BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setContents([
                $boxContent,
                $boxTime,
                TextComponentBuilder::builder()
                    ->setText('26/04/2562')
                    ->setColor('#000000')
                    ->setSize(ComponentIconSize::XXS),
                $boxTimeBaseLine1,

                $boxTime2,
                TextComponentBuilder::builder()
                    ->setText('26/04/2562')
                    ->setColor('#000000')
                    ->setSize(ComponentIconSize::XXS),
                $boxTimeBaseLine2,

                $boxTime3,
                TextComponentBuilder::builder()
                    ->setText('27/04/2562')
                    ->setColor('#000000')
                    ->setSize(ComponentIconSize::XXS),
                $boxTimeBaseLine3,

                $boxTime4,
                TextComponentBuilder::builder()
                    ->setText('27/04/2562')
                    ->setColor('#000000')
                    ->setSize(ComponentIconSize::XXS),
                $boxTimeBaseLine4
            ]);
    }
}