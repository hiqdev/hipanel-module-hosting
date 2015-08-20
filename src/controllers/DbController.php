<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\base\CrudController;
use hipanel\models\Ref;
use Yii;

class DbController extends CrudController
{
    public function actions()
    {
        return [
            'index' => [
                'class'     => 'hipanel\actions\IndexAction',
                'data'  => function ($action) {
                    return [
                        'stateData' => $action->controller->getStateData(),
                    ];
                }
            ],
            'create'          => [
                'class'   => 'hipanel\actions\SmartCreateAction',
                'success' => Yii::t('app', 'DB create task has been created successfully'),
                'error'   => Yii::t('app', 'Error while creating DB'),
            ],
            'set-password'    => [
                'class'   => 'hipanel\actions\SmartUpdateAction',
                'success' => Yii::t('app', 'DB password change task has been created successfully'),
                'error'   => Yii::t('app', 'Error while DB password changing'),
            ],
            'truncate'        => [
                'class'   => 'hipanel\actions\SmartUpdateAction',
                'success' => Yii::t('app', 'DB truncate task has been created successfully'),
                'error'   => Yii::t('app', 'Error while truncating DB'),
            ],
            'set-description' => [
                'class'   => 'hipanel\actions\SmartUpdateAction',
                'success' => Yii::t('app', 'DB description set successfully'),
                'error'   => Yii::t('app', 'Failed to set DB description'),
            ],
            'delete'          => [
                'class'   => 'hipanel\actions\SmartPerformAction',
                'success' => Yii::t('app', 'DB delete task has been created successfully'),
                'error'   => Yii::t('app', 'Error while deleting DB'),
            ],
        ];
    }

    public function getStateData()
    {
        return Ref::getList('state,db');
    }
}
