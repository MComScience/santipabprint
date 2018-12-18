<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 26/11/2561
 * Time: 18:50
 */

namespace kidz\bootstraptoggle;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

class BootstrapToggle extends \yii\widgets\InputWidget
{
    const PLUGIN_NAME = 'bootstrapToggle';

    public $clientOptions = [];

    public $clientEvents = [];

    public $options = [];

    protected $_hashVar;

    public function run()
    {
        $this->registerPlugin(self::PLUGIN_NAME);
        if ($this->hasModel()) {
            echo Html::activeCheckbox($this->model, $this->attribute, $this->options);
        } else {
            echo Html::checkbox($this->name, $this->value, $this->options);
        }
    }

    protected function hashPluginOptions($view)
    {
        $encOptions = empty($this->clientOptions) ? '{}' : Json::encode($this->clientOptions);
        $this->_hashVar = self::PLUGIN_NAME . '_' . hash('crc32', $encOptions);
        $view->registerJs("var {$this->_hashVar} = {$encOptions};\n", View::POS_HEAD);
    }

    protected function registerPlugin($name)
    {
        $view = $this->getView();
        $this->hashPluginOptions($view);

        BootstrapToggleAsset::register($view);

        $id = $this->options['id'];

        $options = $this->_hashVar;
        $js = "jQuery('#$id').$name($options);";
        $view->registerJs($js);

        $this->registerClientEvents();
    }

    protected function registerClientEvents()
    {
        if (!empty($this->clientEvents)) {
            $id = $this->options['id'];
            $js = [];
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = "jQuery('#$id').on('$event', $handler);";
            }
            $this->getView()->registerJs(implode("\n", $js));
        }
    }
}