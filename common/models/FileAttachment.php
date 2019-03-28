<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "file_attachment".
 *
 * @property integer $id
 * @property string $component
 * @property string $base_url
 * @property string $path
 * @property string $type
 * @property integer $size
 * @property string $name
 * @property string $ref_id
 * @property string $ref_table_name
 * @property string $upload_ip
 * @property integer $created_at
 */
class FileAttachment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file_attachment';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'upload_ip',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'upload_ip',
                ],
                'value' => function ($event) {
                    return Yii::$app->request->userIP;
                },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['component', 'base_url', 'path', 'created_at'], 'required'],
            [['size', 'created_at'], 'integer'],
            [['component', 'type', 'name', 'ref_id', 'ref_table_name'], 'string', 'max' => 255],
            [['base_url', 'path'], 'string', 'max' => 1024],
            [['upload_ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'component' => 'Component',
            'base_url' => 'Base Url',
            'path' => 'Path',
            'type' => 'Type',
            'size' => 'Size',
            'name' => 'Name',
            'ref_id' => 'Ref ID',
            'ref_table_name' => 'Ref Table Name',
            'upload_ip' => 'Upload Ip',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @inheritdoc
     * @return FileAttachmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FileAttachmentQuery(get_called_class());
    }
}
