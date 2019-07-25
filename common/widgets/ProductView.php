<?php
namespace common\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap\Widget;
use yii\helpers\Html;

class ProductView extends Widget
{
    public $products;

    public $options = [];

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return Html::tag('div', $this->renderItems(), ['class' => 'row row-product', 'id' => $this->options['id']]);
    }

    protected function renderItems()
    {
        $items = [];
        foreach ($this->products as $product) {
            $className = $this->getClassName($product);
            $items[] = Html::beginTag('div', ['class' => 'col']) .
            Html::beginTag('div', [
                'class' => 'media open-collapse',
                'data-toggle' => 'collapse__35',
                'role' => 'button',
                'aria-expanded' => 'true',
                'aria-controls' => 'collapse__35',
            ]) .
            $this->renderSubItem($product).
            Html::endTag('div') .
            Html::endTag('div');
        }
        return \implode("\n", $items);
    }

    protected function renderSubItem($product)
    {
        $className = $this->getClassName($product);
        return Html::a(
            Html::tag('span', '&nbsp;', ['class' => 'icon']) .
            Html::tag('div', Html::img($product['image_url'], ['class' => 'img-fluid img-responsive center-block']), ['class' => 'product-sub']) .
            Html::tag('div', Html::tag('p', $product['product_name'], ['class' => 'product-sub-name']), ['class' => 'media-body']),
            ['/app/product/quotation', 'p' => $product['product_id'], 'slug' => Yii::$app->slugUrl->create($product['product_name'])],
            [
                'class' => 'product-link product-cate-sub',
                'data-block-id' => 'block_coll_' . $className,
                'data-point-id' => 'point-active-' . $className,
            ]);
    }

    protected function getClassName($product)
    {
        return strtolower(str_replace('.', '_', $product['product_id']));
    }
}
