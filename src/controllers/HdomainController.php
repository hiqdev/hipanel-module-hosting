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

use hipanel\actions\ComboSearchAction;
use hipanel\actions\IndexAction;
use hipanel\actions\PrepareBulkAction;
use hipanel\actions\RedirectAction;
use hipanel\actions\RenderJsonAction;
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartPerformAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\filters\EasyAccessControl;
use Yii;
use yii\base\Event;

class HdomainController extends \hipanel\base\CrudController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => EasyAccessControl::class,
                'actions' => [
                    'create' => 'hdomain.create',
                    'delete' => 'hdomain.delete',
                    '*' => Yii::$app->params['module.hosting.is_public'] || Yii::$app->user->can('support')
                        ? 'hdomain.read'
                        : false,
                ],
            ],
        ]);
    }

    public function actions()
    {
        return array_merge(parent::actions(), [
            'search' => [
                'class' => ComboSearchAction::class,
            ],
            'index' => [
                'class' => IndexAction::class,
                'findOptions' => [
                    'with_vhosts' => true,
                    'with_aliases' => true,
                    'with_request' => true,
                ],
                'data' => function ($action) {
                    return [
                        'stateData' => $action->controller->getStateData(),
                        'typeData' => $action->controller->getTypeData(),
                    ];
                },
                'filterStorageMap' => [
                    'domain_like' => 'domain.hdomain.domain_like',
                    'state'       => 'hosting.hdomain.state',
                    'server'      => 'server.server.name',
                    'account'     => 'hosting.account.login',
                    'client_id'   => 'client.client.id',
                    'seller_id'   => 'client.client.seller_id',
                ],
            ],
            'view' => [
                'class' => ViewAction::class,
                'findOptions' => [
                    'with_vhosts'   => true,
                    'with_aliases'  => true,
                    'with_request'  => true,
                    'show_deleted'  => true,
                    'show_aliases'  => true,
                    'with_blocking' => true,
                ],
                'on beforePerform' => function (Event $event) {
                    /** @var \hipanel\actions\SearchAction $action */
                    $action = $event->sender;
                    $dataProvider = $action->getDataProvider();
                    $dataProvider->query->joinWith(['blocking']);
                },
                'data' => function ($action) {
                    return [
                        'blockReasons' => $this->getBlockReasons(),
                    ];
                },
            ],
            'create' => [
                'class' => SmartCreateAction::class,
                'success' => Yii::t('hipanel:hosting', 'Domain has been created successfully'),
            ],
            'create-alias' => [
                'class' => SmartCreateAction::class,
                'view' => 'create-alias',
                'success' => Yii::t('hipanel:hosting', 'Domain has been created successfully'),
            ],
            'enable-block' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:hosting', 'Domain has been blocked successfully'),
            ],
            'disable-block' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:hosting', 'Domain has been unblocked successfully'),
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
            'enable-paid-feature-autorenewal' => [
                'class' => SmartPerformAction::class,
                'success' => Yii::t('hipanel:hosting', 'Premium autorenewal has been enabled'),
            ],
            'disable-paid-feature-autorenewal' => [
                'class' => SmartPerformAction::class,
                'success' => Yii::t('hipanel:hosting', 'Premium autorenewal has been disabled'),
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('hipanel:hosting', 'Domain has been deleted successfully'),
            ],
            'delete-alias' => [
                'class' => SmartDeleteAction::class,
                'scenario' => 'delete',
                'success' => Yii::t('hipanel:hosting', 'Domain has been deleted successfully'),
            ],
            'bulk-enable-block' => [
                'class' => SmartUpdateAction::class,
                'scenario' => 'enable-block',
                'success' => Yii::t('hipanel:hosting', 'Domains have been blocked successfully'),
                'POST html' => [
                    'save'    => true,
                    'success' => [
                        'class' => RedirectAction::class,
                    ],
                ],
                'on beforeSave' => function (Event $event) {
                    /** @var \hipanel\actions\Action $action */
                    $action = $event->sender;
                    $type = Yii::$app->request->post('type');
                    $comment = Yii::$app->request->post('comment');
                    if (!empty($type)) {
                        foreach ($action->collection->models as $model) {
                            $model->setAttributes([
                                'type' => $type,
                                'comment' => $comment,
                            ]);
                        }
                    }
                },
            ],
            'bulk-enable-block-modal' => [
                'class' => PrepareBulkAction::class,
                'scenario' => 'enable-block',
                'view' => '_bulkEnableBlock',
                'data' => function ($action, $data) {
                    return array_merge($data, [
                        'blockReasons' => $this->getBlockReasons(),
                    ]);
                },
            ],
            'bulk-disable-block' => [
                'class' => SmartUpdateAction::class,
                'scenario' => 'disable-block',
                'success' => Yii::t('hipanel:hosting', 'Domains have been unblocked successfully'),
                'POST html' => [
                    'save'    => true,
                    'success' => [
                        'class' => RedirectAction::class,
                    ],
                ],
                'on beforeSave' => function (Event $event) {
                    /** @var \hipanel\actions\Action $action */
                    $action = $event->sender;
                    $comment = Yii::$app->request->post('comment');
                    if (!empty($type)) {
                        foreach ($action->collection->models as $model) {
                            $model->setAttribute('comment', $comment);
                        }
                    }
                },
            ],
            'bulk-disable-block-modal' => [
                'class' => PrepareBulkAction::class,
                'scenario' => 'disable-block',
                'view' => '_bulkDisableBlock',
            ],
            'set-dns-on' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:hosting', 'DNS settings were changed'),
                'POST html' => [
                    'save'    => true,
                    'success' => [
                        'class' => RedirectAction::class,
                    ],
                ],
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
            'set-premium-autorenewal' => [
                'class' => SmartPerformAction::class,
                'success' => Yii::t('hipanel', 'Premium autorenewal has been changed'),
                'scenario' => 'set-paid-feature-autorenewal',
                'queryOptions' => [
                    'batch' => false,
                ],
                'POST ajax' => [
                    'save' => true,
                    'flash' => true,
                    'success' => [
                        'class' => RenderJsonAction::class,
                        'return' => function ($action) {
                            $message = Yii::$app->session->removeFlash('success');

                            return [
                                'success' => true,
                                'text' => Yii::t('hipanel', reset($message)['text']),
                            ];
                        },
                    ],
                    'error' => [
                        'class' => RenderJsonAction::class,
                        'return' => function ($action) {
                            $message = Yii::$app->session->removeFlash('error');

                            return [
                                'success' => false,
                                'text' => reset($message)['text'],
                            ];
                        },
                    ],
                ],
            ],
            'enable-premium-autorenewal' => [
                'class' => SmartPerformAction::class,
                'scenario' => 'enable-paid-feature-autorenewal',
                'success' => Yii::t('hipanel', 'Autorenewal has been enabled'),
                'error' => Yii::t('hipanel', 'Failed enabling Autorenewal'),
            ],
            'disable-premium-autorenewal' => [
                'class' => SmartPerformAction::class,
                'scenario' => 'disable-paid-feature-autorenewal',
                'success' => Yii::t('hipanel', 'Autorenewal has been disabled'),
                'error' => Yii::t('hipanel', 'Failed disabling Autorenewal'),
            ],
        ]);
    }

    public function getStateData()
    {
        return $this->getRefs('state,hdomain', 'hipanel:hosting');
    }

    public function getTypeData()
    {
        return [
            0 => Yii::t('hipanel', 'Domain'),
            1 => Yii::t('hipanel', 'Alias'),
        ];
    }
}
