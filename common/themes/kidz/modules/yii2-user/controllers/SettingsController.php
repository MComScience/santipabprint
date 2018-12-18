<?php
namespace kidz\user\controllers;

use Yii;
use dektrium\user\controllers\SettingsController as BaseSettingsController;
use trntv\filekit\actions\UploadAction;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Intervention\Image\ImageManagerStatic;
use trntv\filekit\actions\DeleteAction;

class SettingsController extends BaseSettingsController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'disconnect' => ['post'],
                    'delete'     => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['profile', 'account', 'networks', 'disconnect', 'delete','upload-avatar','delete-avatar'],
                        'roles'   => ['@'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['confirm'],
                        'roles'   => ['?', '@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'upload-avatar' => [
                'class' => UploadAction::className(),
                'deleteRoute' => 'delete-avatar',
                'on afterSave' => function ($event) {
                    $cache = Yii::$app->cache;
                    $key = 'avatar-' . Yii::$app->user->id;
                    $cache->delete($key);
                    $file = $event->file;
                    $cache = Yii::$app->cache;
                    $key = 'avatar' . Yii::$app->user->id;
                    $cache->delete($key);
                    $img = ImageManagerStatic::make($file->read())->fit(215, 215);
                    $file->put($img->encode());
                },
            ],
            'delete-avatar' => [
                'class' => DeleteAction::className(),
            ],
        ];
    }
}