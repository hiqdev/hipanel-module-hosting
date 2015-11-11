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
        ];
    }

    public function getObjectOptions()
    {
        return [
            'hdomain' => Yii::t('app', 'Domain'),
            'db' => Yii::t('app', 'Data bases'),
        ];
    }
}
