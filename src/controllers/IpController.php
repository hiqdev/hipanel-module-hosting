<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\models\Ref;
use hipanel\modules\hosting\models\Ip;
use hipanel\modules\hosting\models\Link;
use hiqdev\hiart\Collection;
use hiqdev\hiart\ErrorResponseException;
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
            'create' => [
                'class' => 'hipanel\actions\SmartCreateAction',
                'success' => Yii::t('hipanel/hosting', 'IP address was created successfully'),
                'error' => Yii::t('hipanel/hosting', 'An error occurred when trying to create an IP address'),
                'data' => function ($action) {
                    $linkModels = [];
                    /** @var Ip $model */
                    foreach ($action->collection->models as $model) {
                        if (($links = $model->getAddedLinks()) !== []) {
                            foreach ($links as $link) {
                                $linkModels[] = $link;
                            }
                        }
                    }

                    return [
                        'links' => empty($linkModels) ? [new Link(['scenario' => $action->scenario])] : $linkModels,
                        'tags' => $this->getIpTags()
                    ];
                },
                'collectionLoader' => function ($action, $data) {
                    $this->collectionLoader($action->scenario, $action->collection);
                },
            ],
            'update' => [
                'class' => 'hipanel\actions\SmartUpdateAction',
                'success' => Yii::t('hipanel/hosting', 'IP address was updated successfully'),
                'error' => Yii::t('hipanel/hosting', 'An error occurred when trying to update an IP address'),
                'data' => function ($action) {
                    $linkModels = [];
                    /** @var Ip $model */
                    foreach ($action->collection->models as $model) {
                        if (($links = $model->getAddedLinks()) !== []) {
                            foreach ($links as $link) {
                                $linkModels[] = $link;
                            }
                        }
                    }

                    return [
                        'links' => empty($linkModels) ? [new Link(['scenario' => $action->scenario])] : $linkModels,
                        'tags' => $this->getIpTags()
                    ];
                },
                'collectionLoader' => function ($action, $data) {
                    $this->collectionLoader($action->scenario, $action->collection);
                },
                'on beforeFetch' => function (Event $event) {
                    /** @var \hipanel\actions\SearchAction $action */
                    $action = $event->sender;
                    $dataProvider = $action->getDataProvider();
                    $dataProvider->query->joinWith('links');

                    // TODO: ipModule is not wise yet. Redo
                    $dataProvider->query
                        ->andWhere(['with_links' => 1])
                        ->andWhere(['with_tags' => 1]);
                }
            ],
            'validate-form' => [
                'class' => 'hipanel\actions\ValidateFormAction',
            ]
        ];
    }

    public function getIpTags()
    {
        return Ref::getList('tag,ip');
    }

    public function collectionLoader ($scenario, Collection $collection) {
        $ipModel = $this->newModel(['scenario' => $scenario]);
        $linkModel = new Link(['scenario' => $scenario]);

        $ipModels = [$ipModel];
        for ($i = 1; $i < count(Yii::$app->request->post($ipModel->formName(), [])); $i++) {
            $ipModels[] = clone $ipModel;
        }

        $linkModels = [$linkModel];
        for ($i = 1; $i < count(Yii::$app->request->post($linkModel->formName(), [])); $i++) {
            $linkModels[] = clone $linkModel;
        }

        if (Ip::loadMultiple($ipModels, Yii::$app->request->post())) {
            Link::loadMultiple($linkModels, Yii::$app->request->post());

            /** @var Ip $ip */
            foreach ($ipModels as $i => $ip) {
                /** @var Link $link */
                foreach ($linkModels as $k => $link) {
                    if ($link->ip_id == $i && $link->validate()) {
                        $ip->addLink($link);
                    }
                }
            }

            $collection->set($ipModels);
        }
    }
}
