<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\actions\Action;
use hipanel\models\Ref;
use hipanel\modules\hosting\models\Soft;
use Yii;
use yii\base\Event;
use yii\helpers\ArrayHelper;

class ServiceController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'hipanel\actions\IndexAction',
                'on beforePerform' => function (Event $event) {
                    /** @var \hipanel\actions\SearchAction $action */
                    $action = $event->sender;
                    $dataProvider = $action->getDataProvider();
                    $dataProvider->query->joinWith('ips')->joinWith('objects_count');
                },
            ],
            'view' => [
                'class' => 'hipanel\actions\ViewAction',
            ],
            'create' => [
                'class' => 'hipanel\actions\SmartCreateAction',
                'data' => function ($action) {
                    /** @var Action $action */
                    return [
                        'states' => $action->controller->getStateData(),
                        'softs' => $action->controller->getSofts(),
                    ];
                },
                'success' => Yii::t('hipanel/hosting', 'Service was created successfully'),
                'error' => Yii::t('app', 'An error occurred when trying to create a service')
            ],
            'validate-form' => [
                'class' => 'hipanel\actions\ValidateFormAction',
            ]
        ];
    }

    public function getStateData()
    {
        return Ref::getList('state,service');
    }

    public function getSofts()
    {
        return ArrayHelper::map(Soft::find()->all(), 'id', 'name');
    }
}
