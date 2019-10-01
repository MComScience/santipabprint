<?php

/**
 * Created by PhpStorm.
 * User: Tanakorn Phompak
 * Date: 25/9/2562
 * Time: 9:42
 */

namespace common\modules\webhook\components;

use LINE\LINEBot\Constant\Flex\ComponentLayout;
use LINE\LINEBot\Constant\Flex\ComponentMargin;
use LINE\LINEBot\Constant\Flex\ComponentSpacing;
use LINE\LINEBot\Constant\Flex\ComponentType;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder;
use LINE\LINEBot\TemplateActionBuilder;
use LINE\LINEBot\Util\BuildUtil;

class BoxComponentBuilder implements ComponentBuilder
{
    /** @var ComponentLayout */
    private $layout;
    /** @var ComponentBuilder[] */
    private $componentBuilders;
    /** @var int */
    private $flex;
    /** @var ComponentSpacing */
    private $spacing;
    /** @var ComponentMargin */
    private $margin;
    /** @var TemplateActionBuilder */
    private $actionBuilder;
    /** @var array */
    private $component;
    /** @var string */
    private $backgroundColor;
    /** @var string */
    private $borderColor;
    /** @var string */
    private $borderWidth;
    /** @var string */
    private $cornerRadius;
    /** @var string */
    private $width;
    /** @var string */
    private $height;
    /** @var string */
    private $paddingAll;
    /** @var string */
    private $paddingTop;
    /** @var string */
    private $paddingBottom;
    /** @var string */
    private $paddingStart;
    /** @var string */
    private $paddingEnd;
    /** @var string */
    private $position;
    /** @var string */
    private $offsetTop;
    /** @var string */
    private $offsetBottom;
    /** @var string */
    private $offsetStart;
    /** @var string */
    private $offsetEnd;

    /**
     * BoxComponentBuilder constructor.
     *
     * @param ComponentLayout|string $layout
     * @param ComponentBuilder[] $componentBuilders
     * @param int|null $flex
     * @param ComponentSpacing|string|null $spacing
     * @param ComponentMargin|null $margin
     * @param TemplateActionBuilder|null $actionBuilder
     */
    public function __construct(
        $layout,
        $componentBuilders,
        $flex = null,
        $spacing = null,
        $margin = null,
        $actionBuilder = null,
        $backgroundColor = null,
        $borderColor = null,
        $borderWidth = null,
        $cornerRadius = null,
        $width = null,
        $height = null,
        $paddingAll = null,
        $paddingTop = null,
        $paddingBottom = null,
        $paddingStart = null,
        $paddingEnd = null,
        $position = null,
        $offsetTop = null,
        $offsetBottom = null,
        $offsetStart = null,
        $offsetEnd = null
    )
    {
        $this->layout = $layout;
        $this->componentBuilders = $componentBuilders;
        $this->backgroundColor = $backgroundColor;
        $this->borderColor = $borderColor;
        $this->borderWidth = $borderWidth;
        $this->cornerRadius = $cornerRadius;
        $this->width = $width;
        $this->height = $height;
        $this->flex = $flex;
        $this->spacing = $spacing;
        $this->margin = $margin;
        $this->paddingAll = $paddingAll;
        $this->paddingTop = $paddingTop;
        $this->paddingBottom = $paddingBottom;
        $this->paddingStart = $paddingStart;
        $this->paddingEnd = $paddingEnd;
        $this->position = $position;
        $this->offsetTop = $offsetTop;
        $this->offsetBottom = $offsetBottom;
        $this->offsetStart = $offsetStart;
        $this->offsetEnd = $offsetEnd;
        $this->actionBuilder = $actionBuilder;
    }

    /**
     * Create empty BoxComponentBuilder.
     *
     * @return \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder
     */
    public static function builder()
    {
        return new self(null, null);
    }

    /**
     * Set laytout.
     *
     * @param ComponentLayout|string $layout
     * @return $this
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * Set contents.
     *
     * @param ComponentBuilder[] $componentBuilders
     * @return $this
     */
    public function setContents($componentBuilders)
    {
        $this->componentBuilders = $componentBuilders;
        return $this;
    }

    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;
        return $this;
    }

    public function setBorderColor($borderColor)
    {
        $this->borderColor = $borderColor;
        return $this;
    }

    public function setBorderWidth($borderWidth)
    {
        $this->borderWidth = $borderWidth;
        return $this;
    }

    public function setCornerRadius($cornerRadius)
    {
        $this->cornerRadius = $cornerRadius;
        return $this;
    }

    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * Set flex.
     *
     * @param int|null $flex
     * @return $this
     */
    public function setFlex($flex)
    {
        $this->flex = $flex;
        return $this;
    }

    /**
     * Set spacing.
     *
     * @param ComponentSpacing|string|null $spacing
     * @return $this
     */
    public function setSpacing($spacing)
    {
        $this->spacing = $spacing;
        return $this;
    }

    /**
     * Set margin.
     *
     * @param ComponentMargin|string|null $margin
     * @return $this
     */
    public function setMargin($margin)
    {
        $this->margin = $margin;
        return $this;
    }

    /**
     * Set paddingAll.
     *
     * @param string $paddingAll
     * @return $this
     */
    public function setPaddingAll($paddingAll)
    {
        $this->paddingAll = $paddingAll;
        return $this;
    }

    public function setPaddingTop($paddingTop)
    {
        $this->paddingTop = $paddingTop;
        return $this;
    }

    public function setPaddingBottom($paddingBottom)
    {
        $this->paddingBottom = $paddingBottom;
        return $this;
    }

    public function setPaddingStart($paddingStart)
    {
        $this->paddingStart = $paddingStart;
        return $this;
    }

    public function setPaddingEnd($paddingEnd)
    {
        $this->paddingEnd = $paddingEnd;
        return $this;
    }

    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    public function setOffsetTop($offsetTop)
    {
        $this->offsetTop = $offsetTop;
        return $this;
    }

    public function setOffsetBottom($offsetBottom)
    {
        $this->offsetBottom = $offsetBottom;
        return $this;
    }

    public function setOffsetStart($offsetStart)
    {
        $this->offsetStart = $offsetStart;
        return $this;
    }

    public function setOffsetEnd($offsetEnd)
    {
        $this->offsetEnd = $offsetEnd;
        return $this;
    }

    /**
     * Set action.
     *
     * @param TemplateActionBuilder|null $actionBuilder
     * @return $this
     */
    public function setAction($actionBuilder)
    {
        $this->actionBuilder = $actionBuilder;
        return $this;
    }

    /**
     * Builds box component structure.
     *
     * @return array
     */
    public function build()
    {
        if (isset($this->component)) {
            return $this->component;
        }

        $contents = array_map(function ($componentBuilder) {
            /** @var ComponentBuilder $componentBuilder */
            return $componentBuilder->build();
        }, $this->componentBuilders);

        $this->component = BuildUtil::removeNullElements([
            'type' => ComponentType::BOX,
            'layout' => $this->layout,
            'contents' => $contents,
            'backgroundColor' => $this->backgroundColor,
            'borderColor' => $this->borderColor,
            'borderWidth' => $this->borderWidth,
            'cornerRadius' => $this->cornerRadius,
            'width' => $this->width,
            'height' => $this->height,
            'flex' => $this->flex,
            'spacing' => $this->spacing,
            'margin' => $this->margin,
            'paddingAll' => $this->paddingAll,
            'paddingTop' => $this->paddingTop,
            'paddingBottom' => $this->paddingBottom,
            'paddingStart' => $this->paddingStart,
            'paddingEnd' => $this->paddingEnd,
            'position' => $this->position,
            'offsetTop' => $this->offsetTop,
            'offsetBottom' => $this->offsetBottom,
            'offsetStart' => $this->offsetStart,
            'offsetEnd' => $this->offsetEnd,
            'action' => BuildUtil::build($this->actionBuilder, 'buildTemplateAction'),
        ]);

        return $this->component;
    }
}