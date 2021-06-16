<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\RedirectAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\ViewAction;
use hipanel\base\CrudController;
use hipanel\filters\EasyAccessControl;
use Yii;

class BackupController extends CrudController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => EasyAccessControl::class,
                'actions' => [
                    'delete' => 'backup.delete',
                    '*' => Yii::$app->params['module.hosting.is_public'] || Yii::$app->user->can('support')
                        ? 'backup.read'
                        : false,
                ],
            ],
        ]);
    }

    public function actions()
    {
        return array_merge(parent::actions(), [
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
                ],
            ],
            'view' => [
                'class' => ViewAction::class,
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('hipanel:hosting', 'Backup deleting task has been added to queue'),
                'error' => Yii::t('hipanel:hosting', 'An error occurred when trying to delete backup'),
                'POST html | POST pjax' => [
                    'save' => true,
                    'success' => [
                        'class' => RedirectAction::class,
                    ],
                ],
            ],
        ]);
    }

    public function getObjectOptions()
    {
        return [
            'hdomain' => Yii::t('hipanel:hosting', 'Domain'),
            'db' => Yii::t('hipanel:hosting', 'Data Bases'),
        ];
    }
}
