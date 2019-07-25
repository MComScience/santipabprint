<?php
namespace common\widgets;

use yii\base\InvalidConfigException;
use yii\bootstrap\Widget;
use yii\helpers\Html;

class ProductCatagoryView extends Widget
{
    public $catagorys;

    public $options = [];

    public function init()
    {
        parent::init();
        // if (!$this->catagorys) {
        //     throw new InvalidConfigException("The 'catagorys' option is required.");
        // }
    }

    public function run()
    {
        return Html::tag('div', $this->renderItems(), ['class' => 'row row-product', 'id' => $this->options['id']]);
    }

    protected function renderItems()
    {
        $items = [];
        foreach ($this->catagorys as $catagory) {
            $className = $this->getClassName($catagory);
            $items[] = Html::beginTag('div', ['class' => 'col']) .
            Html::beginTag('div', [
                'class' => 'media open-collapse',
                'data-toggle' => 'collapse__35',
                'role' => 'button',
                'aria-expanded' => 'true',
                'aria-controls' => 'collapse__35',
            ]) .
            $this->renderSubItem($catagory).
            Html::endTag('div') .
            Html::endTag('div');
        }
        return \implode("\n", $items);
    }

    protected function renderSubItem($catagory)
    {
        $className = $this->getClassName($catagory);
        return Html::a(
            Html::tag('span', '&nbsp;', ['class' => 'icon']) .
            Html::tag('div', Html::img($catagory['image_url'], ['class' => 'img-fluid img-responsive center-block']), ['class' => 'product-sub']) .
            Html::tag('div', Html::tag('p', $catagory['product_category_name'], ['class' => 'product-sub-name']), ['class' => 'media-body']),
            ['/app/product/category', 'id' => $catagory['product_category_id']],
            [
                'class' => 'product-link product-cate-sub',
                'data-block-id' => 'block_coll_' . $className,
                'data-point-id' => 'point-active-' . $className,
            ]);
    }

    protected function getClassName($catagory)
    {
        return strtolower(str_replace('.', '_', $catagory['product_category_id']));
    }
}
