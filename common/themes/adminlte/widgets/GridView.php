<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 10/1/2562
 * Time: 13:57
 */
namespace adminlte\widgets;

use kartik\grid\GridExportAsset;
use kartik\grid\GridFloatHeadAsset;
use kartik\grid\GridPerfectScrollbarAsset;
use kartik\grid\GridResizeColumnsAsset;
use kartik\grid\GridResizeStoreAsset;
use kartik\grid\GridView as BaseGridView;
use kartik\grid\GridViewAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;

class GridView extends BaseGridView
{
    protected function registerAssets()
    {
        $view = $this->getView();
        $script = '';
        if ($this->bootstrap) {
            GridViewAsset::register($view);
        }
        $gridId = $this->options['id'];
        $NS = '.' . str_replace('-', '_', $gridId);
        if ($this->export !== false && is_array($this->export) && !empty($this->export)) {
            GridExportAsset::register($view);
            if (!isset($this->_module->downloadAction)) {
                $action = ["/{$this->moduleId}/export/download"];
            } else {
                $action = (array)$this->_module->downloadAction;
            }
            $gridOpts = Json::encode(
                [
                    'gridId' => $gridId,
                    'action' => Url::to($action),
                    'module' => $this->moduleId,
                    'encoding' => ArrayHelper::getValue($this->export, 'encoding', 'utf-8'),
                    'bom' => (int)ArrayHelper::getValue($this->export, 'bom', 1),
                    'target' => ArrayHelper::getValue($this->export, 'target', self::TARGET_BLANK),
                    'messages' => $this->export['messages'],
                    'exportConversions' => $this->exportConversions,
                    'showConfirmAlert' => ArrayHelper::getValue($this->export, 'showConfirmAlert', true),
                ]
            );
            $gridOptsVar = 'kvGridExp_' . hash('crc32', $gridOpts);
            $view->registerJs("var {$gridOptsVar}={$gridOpts};");
            foreach ($this->exportConfig as $format => $setting) {
                $id = "jQuery('#{$gridId} .export-{$format}')";
                $genOpts = Json::encode(
                    [
                        'filename' => $setting['filename'],
                        'showHeader' => $setting['showHeader'],
                        'showPageSummary' => $setting['showPageSummary'],
                        'showFooter' => $setting['showFooter'],
                    ]
                );
                $genOptsVar = 'kvGridExp_' . hash('crc32', $genOpts);
                $view->registerJs("var {$genOptsVar}={$genOpts};");
                $expOpts = Json::encode(
                    [
                        'dialogLib' => ArrayHelper::getValue($this->krajeeDialogSettings, 'libName', 'krajeeDialog'),
                        'gridOpts' => new JsExpression($gridOptsVar),
                        'genOpts' => new JsExpression($genOptsVar),
                        'alertMsg' => ArrayHelper::getValue($setting, 'alertMsg', false),
                        'config' => ArrayHelper::getValue($setting, 'config', []),
                    ]
                );
                $expOptsVar = 'kvGridExp_' . hash('crc32', $expOpts);
                $view->registerJs("var {$expOptsVar}={$expOpts};");
                $script .= "{$id}.gridexport({$expOptsVar});";
            }
        }
        $contId = '#' . $this->containerOptions['id'];
        $container = "jQuery('{$contId}')";
        if ($this->resizableColumns) {
            $rcDefaults = [];
            if ($this->persistResize) {
                GridResizeStoreAsset::register($view);
            } else {
                $rcDefaults = ['store' => null];
            }
            $rcOptions = Json::encode(array_replace_recursive($rcDefaults, $this->resizableColumnsOptions));
            GridResizeColumnsAsset::register($view);
            $script .= "{$container}.resizableColumns('destroy').resizableColumns({$rcOptions});";
        }
        if ($this->floatHeader) {
            GridFloatHeadAsset::register($view);
            // fix floating header for IE browser when using group grid functionality
            $skipCss = '.kv-grid-group-row,.kv-group-header,.kv-group-footer'; // skip these CSS for IE
            $js = 'function($table){return $table.find("tbody tr:not(' . $skipCss . '):visible:first>*");}';
            $opts = [
                'floatTableClass' => 'kv-table-float',
                'floatContainerClass' => 'kv-thead-float',
                'getSizingRow' => new JsExpression($js),
            ];
            if ($this->floatOverflowContainer) {
                $opts['scrollContainer'] = new JsExpression("function(){return {$container};}");
            }
            $this->floatHeaderOptions = array_replace_recursive($opts, $this->floatHeaderOptions);
            $opts = Json::encode($this->floatHeaderOptions);
            $script .= "jQuery('#{$gridId} .kv-grid-table:first').floatThead({$opts});";
            // integrate resizeableColumns with floatThead
            if ($this->resizableColumns) {
                $script .= "{$container}.off('{$NS}').on('column:resize{$NS}', function(e){" .
                    "jQuery('#{$gridId} .kv-grid-table:nth-child(2)').floatThead('reflow');" .
                    '});';
            }
        }
        $psVar = 'ps_' . Inflector::slug($this->containerOptions['id'], '_');
        if ($this->perfectScrollbar) {
            GridPerfectScrollbarAsset::register($view);
            $script .= "var {$psVar} = new PerfectScrollbar('{$contId}', " .
                Json::encode($this->perfectScrollbarOptions) . ');';
        }
        $this->genToggleDataScript();
        $script .= $this->_toggleScript;
        $this->_gridClientFunc = 'kvGridInit_' . hash('crc32', $script);
        $this->options['data-krajee-grid'] = $this->_gridClientFunc;
        $this->options['data-krajee-ps'] = $psVar;
        $view->registerJs("var {$this->_gridClientFunc}=function(){\n{$script}\n};\n{$this->_gridClientFunc}();");
    }

}