<?php

namespace common\modules\app\models;

/**
 * This is the ActiveQuery class for [[TblProductOption]].
 *
 * @see TblProductOption
 */
class TblProductOptionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TblProductOption[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TblProductOption|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
