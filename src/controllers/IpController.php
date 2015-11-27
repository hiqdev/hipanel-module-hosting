<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\models\Ref;
use yii\base\Event;

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
            ]
        ];
    }

    public function getIpTags() {
        return Ref::getList('tag,ip');
    }
}
