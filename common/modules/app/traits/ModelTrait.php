<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 19/1/2562
 * Time: 14:27
 */
namespace common\modules\app\traits;

use common\modules\app\models\TblBookBinding;
use common\modules\app\models\TblCoating;
use common\modules\app\models\TblColorPrinting;
use common\modules\app\models\TblDiecut;
use common\modules\app\models\TblDiecutGroup;
use common\modules\app\models\TblFoilColor;
use common\modules\app\models\TblFold;
use common\modules\app\models\TblPaper;
use common\modules\app\models\TblPaperSize;
use common\modules\app\models\TblPaperType;
use common\modules\app\models\TblProduct;
use common\modules\app\models\TblProductCategory;
use common\modules\app\models\TblProductOption;
use common\modules\app\models\TblQuotation;
use common\modules\app\models\TblQuotationDetail;
use common\modules\app\models\TblUnit;
use common\modules\settings\models\TblProductCatalog;
use yii\web\NotFoundHttpException;

trait ModelTrait
{
    protected function findModelPaperSize($id)
    {
        if (($model = TblPaperSize::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError();
    }

    protected function findModelPaperType($id)
    {
        if (($model = TblPaperType::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError();
    }

    protected function findModelPaper($id)
    {
        if (($model = TblPaper::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError();
    }

    protected function findModelFold($id)
    {
        if (($model = TblFold::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError();
    }

    protected function findModelFoilColor($id)
    {
        if (($model = TblFoilColor::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError();
    }

    protected function findModelCoating($id)
    {
        if (($model = TblCoating::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError();
    }

    protected function findModelDiecutGroup($id)
    {
        if (($model = TblDiecutGroup::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError();
    }

    protected function findModelDiecut($id)
    {
        if (($model = TblDiecut::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError();
    }

    protected function findModelUnit($id)
    {
        if (($model = TblUnit::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError();
    }

    protected function findModelBookBinding($id)
    {
        if (($model = TblBookBinding::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError();
    }

    protected function findModelColorPrinting($id)
    {
        if (($model = TblColorPrinting::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError();
    }

    protected function findModelProductCategory($id)
    {
        if (($model = TblProductCategory::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError();
    }

    protected function findModelProduct($id)
    {
        if (($model = TblProduct::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError();
    }

    protected function findModelProductOption($id)
    {
        if (($model = TblProductOption::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError();
    }

    protected function findModelQuotation($id)
    {
        if (($model = TblQuotation::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError();
    }

    protected function findModelQuotationDetail($id)
    {
        if (($model = TblQuotationDetail::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError();
    }

    protected function findModelProductCatalog($id)
    {
        if (($model = TblProductCatalog::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError();
    }

    protected function handleError()
    {
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}