<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\models\Ref;
use Yii;

class RequestController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'hipanel\actions\IndexAction',
                'data' => function ($action) {
                    return [
                        'objectOptions' => $action->controller->getObjectOptions(),
                        'stateOptions' => $action->controller->getStateOptions(),
                        'typeOptions' => $action->controller->getTypeOptions(),
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

    public function getTypeOptions()
    {
        return Ref::getList('type,request', ['limit' => 'ALL', 'with_recursive' => true, 'select' => 'id']);
    }

    public function getStateOptions()
    {
        return Ref::getList('state,request');
    }

    public function getObjectOptions()
    {
        return [
            ' '         => Yii::t('app', 'All'),
            'db'        => Yii::t('app', 'Database'),
            'hdomain'   => Yii::t('app', 'Domain'),
            'device'    => Yii::t('app', 'Server'),
            'service'   => Yii::t('app', 'Service'),
        ];
    }
}
