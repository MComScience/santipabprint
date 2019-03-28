<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[FileAttachment]].
 *
 * @see FileAttachment
 */
class FileAttachmentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return FileAttachment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FileAttachment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
