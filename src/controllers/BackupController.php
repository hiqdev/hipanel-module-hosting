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
                'success' => Yii::t('hipanel/hosting', 'Backup deleting task has been added to queue'),
                'error' => Yii::t('hipanel/hosting', 'An error occurred when trying to delete backup')
            ],
        ];
    }

    public function getObjectOptions()
    {
        return [
            'hdomain' => Yii::t('hipanel/hosting', 'Domain'),
            'db' => Yii::t('hipanel/hosting', 'Data Bases'),
        ];
    }
}