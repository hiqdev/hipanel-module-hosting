<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\base\Response;
use hipanel\models\Ref;
use hipanel\modules\hosting\models\Ip;
use hipanel\modules\hosting\models\Link;
use Yii;
use yii\base\Event;
use yii\helpers\ArrayHelper;

class IpController extends \hipanel\base\CrudController
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
                    $dataProvider->query->joinWith('links');

                    // TODO: ipModule is not wise yet. Redo
                    $dataProvider->query
                        ->andWhere(['with_links' => 1])
                        ->andWhere(['with_tags' => 1])
                        ->andWhere(['with_counters' => 1]);
                },
                'data' => function ($action) {
                    return [
                        'ipTags' => $action->controller->getIpTags()
                    ];
                }
            ],
            'view' => [
                'class' => 'hipanel\actions\ViewAction',
                'on beforeSave' => function (Event $event) {
                    /** @var \hipanel\actions\SearchAction $action */
                    $action = $event->sender;
                    $dataProvider = $action->getDataProvider();
                    $dataProvider->query->joinWith('links');

                    // TODO: ipModule is not wise yet. Redo
                    $dataProvider->query
                        ->andWhere(['with_links' => 1])
                        ->andWhere(['with_tags' => 1])
                        ->andWhere(['with_counters' => 1]);
                }
            ],
            'create1' => [
                'class' => 'hipanel\actions\SmartCreateAction',
                'data' => function ($action) {
                    $a = 1;
                    return [
                        'test' => '123'
                    ];
                },
            ],
            'validate-form' => [
                'class' => 'hipanel\actions\ValidateFormAction',
            ]
        ];
    }

    public function actionCreate() {
        /**
         * @var Ip $model
         */
        $model = $this->newModel(['scenario' => 'create']);
        $links = [new Link()];

        return $this->render('create', [
            'model' => $model,
            'models' => [$model],
            'links' => $links,
            'tags' => $this->getIpTags()
        ]);
//        'success' => Yii::t('hipanel/hosting', 'IP address was created successfully'),
//        'error' => Yii::t('hipanel/hosting', 'An error occurred when trying to create an IP address')

    }

    public function getIpTags() {
        return Ref::getList('tag,ip');
    }
}
