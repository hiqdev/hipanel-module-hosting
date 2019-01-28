<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartPerformAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\helpers\ArrayHelper;
use hipanel\models\Ref;
use hipanel\modules\hosting\models\Backuping;
use hipanel\modules\hosting\models\BackupSearch;
use hipanel\filters\EasyAccessControl;
use Yii;
use yii\filters\AccessControl;

class BackupingController extends \hipanel\base\CrudController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => EasyAccessControl::class,
                'actions' => [
                    'update' => 'account.update',
                    'delete' => 'account.delete',
                    '*' => 'account.read',
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
                        'stateOptions' => $action->controller->getStateOptions(),
                    ];
                },
                'filterStorageMap' => [
                    'state' => 'hosting.backuping.state',
                    'server' => 'server.server.name',
                    'account' => 'hosting.account.login',
                    'client_id' => 'client.client.id',
                ],
            ],
            'update' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:hosting', 'Backup settings have been changed'),
                'data' => function ($action) {
                    return [
                        'methodOptions' => $action->controller->getMethodOptions(),
                        'dayOptions' => $action->controller->getDayOptions(),
                        'hourOptions' => $action->controller->getHourOptions(),
                    ];
                },
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
                        'backupsDataProvider' => $backupsDataProvider,
                        'hasBackup' => Backuping::find()->where(['id' => $action->getId()])->exists(),
                    ];
                },
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
        ]);
    }

    public function getDayOptions()
    {
        return ArrayHelper::map(Ref::find()->where(['gtype' => 'type,day', 'select' => 'full'])->all(), 'id', function ($model) {
            return Yii::t('hipanel:hosting', $model->label);
        });
    }

    public function getHourOptions()
    {
        return ArrayHelper::map(Ref::find()->where(['gtype' => 'type,hour', 'select' => 'full'])->all(), 'id', function ($model) {
            return Yii::t('hipanel:hosting', $model->label);
        });
    }

    public function getMethodOptions()
    {
        return $this->getRefs('type,backup_method', 'hipanel:hosting');
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
