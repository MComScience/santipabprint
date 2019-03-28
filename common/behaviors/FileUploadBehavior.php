<?php
namespace common\behaviors;

use trntv\filekit\behaviors\UploadBehavior as BaseUploadBehavior;

class FileUploadBehavior extends BaseUploadBehavior
{
    public $ref_id;
    public $ref_table_name;

    protected function saveFilesToRelation($files)
    {
        $modelClass = $this->getUploadModelClass();
        foreach ($files as $file) {
            $model = new $modelClass;
            $model->ref_id = $this->ref_id;
            $model->ref_table_name = $this->ref_table_name;
            $model->component = 'fileStorage';
            $model->setScenario($this->uploadModelScenario);
            $model = $this->loadModel($model, $file);
            if ($this->getUploadRelation()->via !== null) {
                $model->save(false);
            }
            $this->owner->link($this->uploadRelation, $model);
        }
    }
}
