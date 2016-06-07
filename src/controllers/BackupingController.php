<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\OrientationAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartPerformAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ViewAction;
use hipanel\models\Ref;
use hipanel\modules\hosting\models\Backup;
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
                'success' => Yii::t('app', 'Deleted'),
                'error' => Yii::t('app', 'Something went wrong.'),
            ],
            'view' => [
                'class' => ViewAction::class,
                'data' => function ($action) {
                    $backupSearch = new BackupSearch();
                    $backupsDataProvider = $backupSearch->search([$backupSearch->formName() => ['object_id' => $action->getId()]]);
                    return [
                        'stateOptions' => $action->controller->getStateOptions(),
                        'typeOptions' => $action->controller->getTypeOptions(),
                        'backupsDataProvider' => $backupsDataProvider
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
