<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\PerformAction;
use hipanel\actions\RenderAction;
use hipanel\actions\SearchAction;
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\SwitchAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
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
                'class' => IndexAction::class,
                'on beforePerform' => $this->getDataProviderOptions(),
                'data' => function ($action) {
                    return [
                        'ipTags' => $action->controller->getIpTags()
                    ];
                }
            ],
            'search-service-edit' => [
                'class' => SearchAction::class,
                'on beforePerform' => $this->getDataProviderOptions(),
                'ajaxResponseFormatter' => function ($action) {
                    /** @var SearchAction $action */
                    $data = [];
                    $results = [];

                    foreach ($action->collection->models as $k => $v) {
                        $data[$k] = ArrayHelper::toArray($v, $action->parent->getReturnOptions());
                    }

                    $device = Yii::$app->request->post('server');

                    foreach ($data as $item) {
                        if ($device && $item['links']) {
                            foreach ($item['links'] as $link) {
                                if ($link['device'] == $device) {
                                    $results[] = ArrayHelper::merge($item, [
                                        'service' => $link['service'],
                                        'device' => $link['device'],
                                    ]);
                                }
                            }
                        } else {
                            $results[] = $item;
                        }
                    }

                    return $results;
                }
            ],
            'view' => [
                'class' => ViewAction::class,
                'on beforePerform' => $this->getDataProviderOptions(),
            ],
            'create' => [
                'class' => SmartCreateAction::class,
                'success' => Yii::t('hipanel/hosting', 'IP address was created successfully'),
                'error' => Yii::t('hipanel/hosting', 'An error occurred when trying to create an IP address'),
                'data' => function ($action, $data) {
                    /** @var Ip $model */
                    foreach ($data['models'] as $model) {
                        if (empty($model->getAddedLinks())) {
                            $model->addLink(new Link(['scenario' => 'create']));
                        }
                    }

                    return [
                        'tags' => $this->getIpTags()
                    ];
                },
                'collectionLoader' => function ($action, $data) {
                    $this->collectionLoader($action->scenario, $action->collection);
                },
            ],
            'update' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel/hosting', 'IP address was updated successfully'),
                'error' => Yii::t('hipanel/hosting', 'An error occurred when trying to update an IP address'),
                'data' => function ($action, $data = []) {
                    /** @var Ip $model */
                    foreach ($data['models'] as $model) {
                        if (empty($model->getAddedLinks())) {
                            if (empty($model->links)) {
                                $model->addLink(new Link(['scenario' => 'create']));
                            } else {
                                $model->setAddedLinks($model->links);
                            }
                        }
                    }

                    return [
                        'tags' => $this->getIpTags()
                    ];
                },
                'collectionLoader' => function ($action, $data) {
                    $this->collectionLoader($action->scenario, $action->collection);
                },
                'on beforeFetch' => $this->getDataProviderOptions(),
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
        ];
    }

    public function getIpTags()
    {
        return Ref::getList('tag,ip');
    }

    public function actionExpand($id)
    {
        try {
            $ips = Ip::perform('Expand', ['id' => $id, 'with_existing' => true]);
        } catch (ErrorResponseException $e) {
            if ($e->getMessage() == 'result is too long') {
                return Yii::t('hipanel/hosting', 'Too many IP addresses in the network');
            }
            throw $e;
        }
        return $this->renderAjax('expand', ['ips' => $ips]);
    }

    public function collectionLoader($scenario, Collection $collection)
    {
        $ipModel = $this->newModel(['scenario' => $scenario]);
        $linkModel = new Link(['scenario' => $scenario]);

        $ipModels = [$ipModel];
        for ($i = 1; $i < count(Yii::$app->request->post($ipModel->formName(), [])); $i++) {
            $ipModels[] = clone $ipModel;
        }

        if (Ip::loadMultiple($ipModels, Yii::$app->request->post())) {
            /** @var Ip $ip */
            foreach ($ipModels as $i => $ip) {
                $ipLinkModels = [$linkModel];
                $ipLinks = ArrayHelper::getValue(Yii::$app->request->post($linkModel->formName(), []), $i, []);
                for ($i = 1; $i < count($ipLinks); $i++) {
                    $ipLinkModels[] = clone $linkModel;
                }
                Link::loadMultiple($ipLinkModels, [$linkModel->formName() => $ipLinks]);

                /** @var Link $link */
                foreach ($ipLinkModels as $link) {
                    if ($link->ip_id == $ip->id && $link->validate()) {
                        $ip->addLink($link);
                    }
                }
            }

            $collection->set($ipModels);
        }
    }

    /**
     * @return \Closure
     */
    public function getDataProviderOptions() {
        return function (Event $event) {
            /** @var \hipanel\actions\SearchAction $action */
            $action = $event->sender;
            $dataProvider = $action->getDataProvider();
            $dataProvider->query->joinWith('links');

            // TODO: ipModule is not wise yet. Redo
            $dataProvider->query
                ->andWhere(['with_links' => 1])
                ->andWhere(['with_tags' => 1])
                ->andWhere(['with_counters' => 1]);
        };
    }
}
