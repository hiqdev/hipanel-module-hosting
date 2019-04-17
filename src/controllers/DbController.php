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
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartPerformAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\base\CrudController;
use hipanel\filters\EasyAccessControl;
use Yii;
use yii\base\Event;

class DbController extends CrudController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => EasyAccessControl::class,
                'actions' => [
                    'create' => 'account.create',
                    'delete,truncate' => 'account.delete',
                    'set-password,set-description' => 'account.update',
                    '*' => 'account.read',
                ],
            ],
        ]);
    }

    public function actions()
    {
        return array_merge(parent::actions(), [
            'index' => [
                'class'     => IndexAction::class,
                'data'  => function ($action) {
                    return [
                        'stateData' => $action->controller->getStateData(),
                    ];
                },
                'filterStorageMap' => [
                    'name_like' => 'hosting.db.name_like',
                    'state'     => 'hosting.db.state',
                    'account'   => 'hosting.account.login',
                    'server'    => 'server.server.name',
                    'client_id' => 'client.client.id',
                    'seller_id' => 'client.client.seller_id',
                ],
            ],
            'view' => [
                'class'   => ViewAction::class,
            ],
            'create' => [
                'class'   => SmartCreateAction::class,
                'success' => Yii::t('hipanel:hosting', 'DB has been created successfully'),
            ],
            'set-password' => [
                'class'   => SmartUpdateAction::class,
                'success' => Yii::t('hipanel', 'Password been changed successfully'),
            ],
            'truncate' => [
                'class'   => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:hosting', 'DB has been truncated successfully'),
            ],
            'set-description' => [
                'class'   => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:hosting', 'Description has been changed successfully'),
            ],
            'validate-form' => [
                'class'   => ValidateFormAction::class,
            ],
            'delete' => [
                'class'   => SmartDeleteAction::class,
                'success' => Yii::t('hipanel:hosting', 'DB has been deleted successfully'),
            ],
            'enable-backuping' => [
                'class' => SmartPerformAction::class,
                'success' => Yii::t('hipanel:hosting', 'Backups were enabled for the domain'),
                'on beforeSave' => function (Event $event) {
                    /** @var \hipanel\actions\Action $action */
                    $action = $event->sender;
                    foreach ($action->collection->models as $model) {
                        $model->setAttribute('backuping_type', 'week');
                    }
                },
            ],
        ]);
    }

    public function getStateData()
    {
        return $this->getRefs('state,db', 'hipanel:hosting');
    }
}
