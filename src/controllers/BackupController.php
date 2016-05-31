<?php

namespace hipanel\modules\hosting\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\OrientationAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\ViewAction;
use Yii;

class BackupController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'set-orientation' => [
                'class' => OrientationAction::class,
                'allowedRoutes' => [
                    '/hosting/backup/index'
                ]
            ],
            'index' => [
                'class' => IndexAction::class,
                'data' => function ($action) {
                    return [
                        'objectOptions' => $action->controller->getObjectOptions(),
                    ];
                },
                'filterStorageMap' => [
                    'name_like' => 'hosting.backup.name_like',
                    'type' => 'hosting.backup.type',
                    'state' => 'hosting.backup.state',
                    'server' => 'server.server.name',
                    'account' => 'hosting.account.login',
                    'client_id' => 'client.client.id',
                ]
            ],
            'view' => [
                'class' => ViewAction::class,
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
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
