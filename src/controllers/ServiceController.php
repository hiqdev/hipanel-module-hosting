<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

/**
 * @see    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\actions\Action;
use hipanel\actions\IndexAction;
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\filters\EasyAccessControl;
use hipanel\modules\hosting\models\Soft;
use Yii;
use yii\base\Event;
use yii\helpers\ArrayHelper;

class ServiceController extends \hipanel\base\CrudController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => EasyAccessControl::class,
                'actions' => [
                    'create' => 'service.create',
                    'update' => 'service.update',
                    'delete' => 'service.delete',
                    '*' => Yii::$app->params['module.hosting.is_public'] || Yii::$app->user->can('support')
                        ? 'service.read'
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
                'on beforePerform' => function (Event $event) {
                    /** @var \hipanel\actions\SearchAction $action */
                    $action = $event->sender;
                    $dataProvider = $action->getDataProvider();
                    $dataProvider->query->joinWith(['ips'])->addSelect('objects_count');
                },
                'filterStorageMap' => [
                    'ip' => 'hosting.ip.ip',
                    'state' => 'hosting.service.state',
                    'server' => 'server.server.name',
                    'account' => 'hosting.account.login',
                    'client_id' => 'client.client.id',
                ],
                'data' => function ($action) {
                    return [
                        'stateData' => $this->getStateData(),
                        'softData' => $this->getSofts(),
                    ];
                },
            ],
            'view' => [
                'class' => ViewAction::class,
                'on beforeSave' => function (Event $event) {
                    /** @var \hipanel\actions\SearchAction $action */
                    $action = $event->sender;
                    $dataProvider = $action->getDataProvider();
                    $dataProvider->query->joinWith('ips')->addSelect('objects_count');
                },
            ],
            'create' => [
                'class' => SmartCreateAction::class,
                'data' => function ($action) {
                    /** @var Action $action */
                    return [
                        'states' => $action->controller->getStateData(),
                        'softs' => $action->controller->getSofts(),
                    ];
                },
                'success' => Yii::t('hipanel:hosting', 'Service was created successfully'),
                'error' => Yii::t('hipanel:hosting', 'An error occurred when trying to create a service'),
            ],
            'update' => [
                'class' => SmartUpdateAction::class,
                'data' => function ($action) {
                    /** @var Action $action */
                    return [
                        'states' => $action->controller->getStateData(),
                        'softs' => $action->controller->getSofts(),
                    ];
                },
                'on beforeFetchLoad' => function (Event $event) {
                    /** @var \hipanel\actions\SearchAction $action */
                    $action = $event->sender;
                    $dataProvider = $action->getDataProvider();
                    $dataProvider->query->joinWith('ips');
                },
                'success' => Yii::t('hipanel:hosting', 'Service was updated successfully'),
                'error' => Yii::t('hipanel:hosting', 'An error occurred when trying to update a service'),
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
        ]);
    }

    public function getStateData()
    {
        return $this->getRefs('state,service', 'hipanel:hosting');
    }

    public function getSofts()
    {
        $softs = Soft::find()->all();

        return ArrayHelper::map($softs, 'name', 'name');
    }
}
