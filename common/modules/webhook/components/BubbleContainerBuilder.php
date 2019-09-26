<?php

/**
 * Created by PhpStorm.
 * User: Tanakorn Phompak
 * Date: 26/9/2562
 * Time: 23:14
 */

namespace common\modules\webhook\components;

use LINE\LINEBot\Constant\Flex\ContainerDirection;
use LINE\LINEBot\Constant\Flex\ContainerType;
use LINE\LINEBot\MessageBuilder\Flex\BubbleStylesBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ImageComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder;
use LINE\LINEBot\Util\BuildUtil;

class BubbleContainerBuilder implements ContainerBuilder
{
    /** @var ContainerDirection */
    private $direction;
    /** @var BoxComponentBuilder */
    private $headerComponentBuilder;
    /** @var ImageComponentBuilder */
    private $heroComponentBuilder;
    /** @var BoxComponentBuilder */
    private $bodyComponentBuilder;
    /** @var BoxComponentBuilder */
    private $footerComponentBuilder;
    /** @var BubbleStylesBuilder */
    private $stylesBuilder;

    /** @var array */
    private $container;

    private $size;

    /**
     * BubbleContainerBuilder constructor.
     *
     * @param ContainerDirection|null $direction
     * @param BoxComponentBuilder|null $headerComponentBuilder
     * @param ImageComponentBuilder|null $heroComponentBuilder
     * @param BoxComponentBuilder|null $bodyComponentBuilder
     * @param BoxComponentBuilder|null $footerComponentBuilder
     * @param BubbleStylesBuilder|null $stylesBuilder
     */
    public function __construct(
        $direction = null,
        $headerComponentBuilder = null,
        $heroComponentBuilder = null,
        $bodyComponentBuilder = null,
        $footerComponentBuilder = null,
        $stylesBuilder = null,
        $size = null
    )
    {
        $this->direction = $direction;
        $this->headerComponentBuilder = $headerComponentBuilder;
        $this->heroComponentBuilder = $heroComponentBuilder;
        $this->bodyComponentBuilder = $bodyComponentBuilder;
        $this->footerComponentBuilder = $footerComponentBuilder;
        $this->stylesBuilder = $stylesBuilder;
        $this->size = $size;
    }

    /**
     * Create empty BubbleContainerBuilder.
     *
     * @return \LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\BubbleContainerBuilder
     */
    public static function builder()
    {
        return new self();
    }

    /**
     * Set direction.
     *
     * @param ContainerDirection|string|null $direction
     * @return BubbleContainerBuilder
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;
        return $this;
    }

    /**
     * Set header.
     *
     * @param BoxComponentBuilder|null $headerComponentBuilder
     * @return BubbleContainerBuilder
     */
    public function setHeader($headerComponentBuilder)
    {
        $this->headerComponentBuilder = $headerComponentBuilder;
        return $this;
    }

    /**
     * Set hero.
     *
     * @param ImageComponentBuilder|null $heroComponentBuilder
     * @return BubbleContainerBuilder
     */
    public function setHero($heroComponentBuilder)
    {
        $this->heroComponentBuilder = $heroComponentBuilder;
        return $this;
    }

    /**
     * Set body.
     *
     * @param BoxComponentBuilder|null $bodyComponentBuilder
     * @return BubbleContainerBuilder
     */
    public function setBody($bodyComponentBuilder)
    {
        $this->bodyComponentBuilder = $bodyComponentBuilder;
        return $this;
    }

    /**
     * Set footer.
     *
     * @param BoxComponentBuilder|null $footerComponentBuilder
     * @return BubbleContainerBuilder
     */
    public function setFooter($footerComponentBuilder)
    {
        $this->footerComponentBuilder = $footerComponentBuilder;
        return $this;
    }

    /**
     * Set style.
     *
     * @param BubbleStylesBuilder|null $stylesBuilder
     * @return BubbleContainerBuilder
     */
    public function setStyles($stylesBuilder)
    {
        $this->stylesBuilder = $stylesBuilder;
        return $this;
    }

    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Builds bubble container structure.
     *
     * @return array
     */
    public function build()
    {
        if (!empty($this->container)) {
            return $this->container;
        }

        $this->container = BuildUtil::removeNullElements([
            'type' => ContainerType::BUBBLE,
            'direction' => $this->direction,
            'size' => $this->size,
            'header' => BuildUtil::build($this->headerComponentBuilder),
            'hero' => BuildUtil::build($this->heroComponentBuilder),
            'body' => BuildUtil::build($this->bodyComponentBuilder),
            'footer' => BuildUtil::build($this->footerComponentBuilder),
            'styles' => BuildUtil::build($this->stylesBuilder),
        ]);

        return $this->container;
    }
}
