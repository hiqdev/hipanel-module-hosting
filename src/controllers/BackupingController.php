<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\models\Ref;
use Yii;

class BackupingController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'hipanel\actions\IndexAction',
                'data' => function ($action) {
                    return [
                        'stateOptions' => $action->controller->getStateOptions(),
                        'typeOptions' => $action->controller->getTypeOptions(),
                    ];
                },
            ],
            'update' => [
                'class' => 'hipanel\actions\SmartUpdateAction',
            ],
            'disable' => [
                'class' => 'hipanel\actions\SmartPerformAction',
            ],
            'enable' => [
                'class' => 'hipanel\actions\SmartPerformAction',
            ],
            'delete' => [
                'class' => 'hipanel\actions\SmartDeleteAction',
                'success' => Yii::t('app', 'Deleted'),
                'error' => Yii::t('app', 'Something went wrong.'),
            ],
            'view' => [
                'class' => 'hipanel\actions\ViewAction',
                'data' => function ($action) {
                    return [
                        'stateOptions' => $action->controller->getStateOptions(),
                        'typeOptions' => $action->controller->getTypeOptions(),
                    ];
                },
            ],
        ];
    }

    public function getTypeOptions()
    {
        return Ref::getList('type,backuping');
    }

    public function getStateOptions()
    {
        return [
            'ok' => Yii::t('app', 'Ok'),
            'disabled' => Yii::t('app', 'Disabled'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }
}
