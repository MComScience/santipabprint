<?php

namespace common\modules\app\models;

/**
 * This is the ActiveQuery class for [[TblPaperDetail]].
 *
 * @see TblPaperDetail
 */
class TblPaperDetailQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TblPaperDetail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TblPaperDetail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
