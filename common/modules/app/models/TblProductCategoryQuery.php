<?php

namespace common\modules\app\models;

/**
 * This is the ActiveQuery class for [[TblProductCategory]].
 *
 * @see TblProductCategory
 */
class TblProductCategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TblProductCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TblProductCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
