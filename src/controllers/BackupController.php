<?php

namespace hipanel\modules\hosting\controllers;

use Yii;

class BackupController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'hipanel\actions\IndexAction',
                'data' => function ($action) {
                    return [
                        'objectOptions' => $action->controller->getObjectOptions(),
                    ];
                },
            ],
            'view' => [
                'class' => 'hipanel\actions\ViewAction',
            ],
            'delete' => [
                'class' => 'hipanel\actions\SmartDeleteAction',
                'success' => Yii::t('app', 'Backup deleting task has been added to queue'),
                'error' => Yii::t('app', 'An error occurred when trying to delete backup')
            ],
        ];
    }

    public function getObjectOptions()
    {
        return [
            'hdomain' => Yii::t('app', 'Domain'),
            'db' => Yii::t('app', 'Data Bases'),
        ];
    }
}