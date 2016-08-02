<?php

/*
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\OrientationAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartPerformAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ViewAction;
use hipanel\modules\hosting\models\Backuping;
use hipanel\modules\hosting\models\BackupSearch;
use Yii;

class BackupingController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'set-orientation' => [
                'class' => OrientationAction::class,
                'allowedRoutes' => [
                    '/hosting/backuping/index'
                ]
            ],
            'index' => [
                'class' => IndexAction::class,
                'data' => function ($action) {
                    return [
                        'stateOptions' => $action->controller->getStateOptions(),
                        'typeOptions' => $action->controller->getTypeOptions(),
                    ];
                },
                'filterStorageMap' => [
                    'state' => 'hosting.backuping.state',
                    'server' => 'server.server.name',
                    'account' => 'hosting.account.login',
                    'client_id' => 'client.client.id',
                ]
            ],
            'update' => [
                'class' => SmartUpdateAction::class,
            ],
            'disable' => [
                'class' => SmartPerformAction::class,
            ],
            'enable' => [
                'class' => SmartPerformAction::class,
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('hipanel', 'Deleted'),
                'error' => Yii::t('hipanel', 'An error occurred. Try again please.'),
            ],
            'view' => [
                'class' => ViewAction::class,
                'findOptions' => ['show_deleted' => true],
                'data' => function ($action) {
                    $backupSearch = new BackupSearch();
                    $backupsDataProvider = $backupSearch->search([$backupSearch->formName() => ['object_id' => $action->getId()]]);
                    $backupsDataProvider->setSort(['defaultOrder' => ['time' => SORT_DESC]]);

                    return [
                        'stateOptions' => $action->controller->getStateOptions(),
                        'typeOptions' => $action->controller->getTypeOptions(),
                        'backupsDataProvider' => $backupsDataProvider,
                        'hasBackup' => Backuping::find()->where(['id' => $action->getId()])->exists(),
                    ];
                },
            ],
        ];
    }

    public function getTypeOptions()
    {
        return $this->getRefs('type,backuping', 'hipanel/hosting');
    }

    public function getStateOptions()
    {
        return [
            'ok' => Yii::t('hipanel', 'Ok'),
            'disabled' => Yii::t('hipanel', 'Disabled'),
            'deleted' => Yii::t('hipanel', 'Deleted'),
        ];
    }
}
