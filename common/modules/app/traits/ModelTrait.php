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
use common\modules\app\models\TblPerforate;
use common\modules\app\models\TblPerforateOption;
use common\modules\app\models\TblPackageType;
use common\modules\app\models\TblBillPrice;

trait ModelTrait {

    protected function findModelPaperSize($id) {
        if (($model = TblPaperSize::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError('TblPaperSize');
    }

    protected function findModelPaperType($id) {
        if (($model = TblPaperType::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError('TblPaperType');
    }

    protected function findModelPaper($id) {
        if (($model = TblPaper::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError('TblPaper');
    }

    protected function findModelFold($id) {
        if (($model = TblFold::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError('TblFold');
    }

    protected function findModelFoilColor($id) {
        if (($model = TblFoilColor::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError('TblFoilColor');
    }

    protected function findModelCoating($id) {
        if (($model = TblCoating::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError('TblCoating');
    }

    protected function findModelDiecutGroup($id) {
        if (($model = TblDiecutGroup::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError('TblDiecutGroup');
    }

    protected function findModelDiecut($id) {
        if (($model = TblDiecut::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError('TblDiecut');
    }

    protected function findModelUnit($id) {
        if (($model = TblUnit::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError('TblUnit');
    }

    protected function findModelBookBinding($id) {
        if (($model = TblBookBinding::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError('TblBookBinding');
    }

    protected function findModelColorPrinting($id) {
        if (($model = TblColorPrinting::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError('TblColorPrinting');
    }

    protected function findModelProductCategory($id) {
        if (($model = TblProductCategory::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError('TblProductCategory');
    }

    protected function findModelProduct($id) {
        if (($model = TblProduct::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError('TblProduct');
    }

    protected function findModelProductOption($id) {
        if (($model = TblProductOption::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError('TblProductOption');
    }

    protected function findModelQuotation($id) {
        if (($model = TblQuotation::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError('TblQuotation');
    }

    protected function findModelQuotationDetail($id) {
        if (($model = TblQuotationDetail::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError('TblQuotationDetail');
    }

    protected function findModelProductCatalog($id) {
        if (($model = TblProductCatalog::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError('TblProductCatalog');
    }

    protected function handleError($model = '') {
        throw new NotFoundHttpException('The requested page does not exist. model ['.$model.']');
    }

    protected function findModelPerforate($id) {
        if (($model = TblPerforate::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError('TblPerforate');
    }

    protected function findModelPerforateOption($id) {
        if (($model = TblPerforateOption::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError('TblPerforateOption');
    }

    protected function findModelPackageType($id) {
        if (($model = TblPackageType::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError('TblPackageType');
    }
    
    protected function findModelBillPrice($id) {
        if (($model = TblBillPrice::findOne($id)) !== null) {
            return $model;
        }
        $this->handleError('TblBillPrice');
    }

}
