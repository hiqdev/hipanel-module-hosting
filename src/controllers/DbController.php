<?php

/*
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\OrientationAction;
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartPerformAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\base\CrudController;
use Yii;

class DbController extends CrudController
{
    public function actions()
    {
        return [
            'set-orientation' => [
                'class' => OrientationAction::class,
                'allowedRoutes' => [
                    '/hosting/db/index'
                ]
            ],
            'index' => [
                'class'     => IndexAction::class,
                'data'  => function ($action) {
                    return [
                        'stateData' => $action->controller->getStateData(),
                    ];
                },
                'filterStorageMap' => [
                    'name_like' => 'hosting.db.name_like',
                    'state' => 'hosting.db.state',
                    'account' => 'hosting.account.login',
                    'server' => 'server.server.name',
                    'client_id' => 'client.client.id',
                    'seller_id' => 'client.client.seller_id',
                ]
            ],
            'view' => [
                'class'   => ViewAction::class
            ],
            'create'          => [
                'class'   => SmartCreateAction::class,
                'success' => Yii::t('app', 'DB create task has been created successfully'),
                'error'   => Yii::t('app', 'Error while creating DB'),
            ],
            'set-password'    => [
                'class'   => SmartUpdateAction::class,
                'success' => Yii::t('app', 'DB password change task has been created successfully'),
                'error'   => Yii::t('app', 'Error while DB password changing'),
            ],
            'truncate'        => [
                'class'   => SmartUpdateAction::class,
                'success' => Yii::t('app', 'DB truncate task has been created successfully'),
                'error'   => Yii::t('app', 'Error while truncating DB'),
            ],
            'set-description' => [
                'class'   => SmartUpdateAction::class,
                'success' => Yii::t('app', 'DB description set successfully'),
                'error'   => Yii::t('app', 'Failed to set DB description'),
            ],
            'validate-form'   => [
                'class'   => ValidateFormAction::class,
            ],
            'delete'          => [
                'class'   => SmartPerformAction::class,
                'success' => Yii::t('app', 'DB delete task has been created successfully'),
                'error'   => Yii::t('app', 'Error while deleting DB'),
            ],
        ];
    }

    public function getStateData()
    {
        return $this->getRefs('state,db', 'hipanel/hosting');
    }
}
