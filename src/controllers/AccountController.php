<?php

/*
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\OrientationAction;
use hipanel\actions\PrepareBulkAction;
use hipanel\actions\RedirectAction;
use hipanel\actions\SearchAction;
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use Yii;
use yii\base\Event;

class AccountController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'set-orientation' => [
                'class' => OrientationAction::class,
                'allowedRoutes' => [
                    '/hosting/account/index'
                ]
            ],
            'index' => [
                'class' => IndexAction::class,
                'data' => function ($action) {
                    return [
                        'stateData' => $action->controller->getStateData(),
                        'typeData' => $action->controller->getTypeData(),
                    ];
                },
                'filterStorageMap' => [
                    'login_like' => 'hosting.account.login',
                    'server' => 'server.server.name',
                    'state' => 'hosting.account.state',
                    'type' => 'hosting.account.type',
                    'client_id' => 'client.client.id',
                    'seller_id' => 'client.client.seller_id',
                ]
            ],
            'view' => [
                'class' => ViewAction::class,
                'findOptions' => [
                    'with_mail_settings' => true
                ],
                'data' => function ($action) {
                    return [
                        'blockReasons' => $action->controller->getBlockReasons()
                    ];
                }
            ],
            'create' => [
                'class' => SmartCreateAction::class,
                'success' => Yii::t('hipanel:hosting', 'Account creating task has been added to queue'),
                'error' => Yii::t('hipanel:hosting', 'An error occurred when trying to create account')
            ],
            'create-ftponly' => [
                'class' => SmartCreateAction::class,
                'success' => Yii::t('hipanel:hosting', 'Account creating task has been added to queue'),
                'error' => Yii::t('hipanel:hosting', 'An error occurred when trying to create account')
            ],
            'set-password' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:hosting', 'Password has been changed'),
                'error' => Yii::t('hipanel:hosting', 'Failed to change password'),
            ],
            'set-allowed-ips' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:hosting', 'Allowed IPs changing task has been successfully added to queue'),
                'error' => Yii::t('hipanel:hosting', 'An error occurred when trying to change allowed IPs'),
            ],
            'set-mail-settings' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:hosting', 'Mail settings where changed'),
                'error' => Yii::t('hipanel:hosting', 'An error occurred when trying to change mail settings'),
            ],
            'enable-block' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:hosting', 'Account was blocked successfully'),
                'error' => Yii::t('hipanel:hosting', 'Error during the account blocking'),
            ],
            'disable-block' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:hosting', 'Account was unblocked successfully'),
                'error' => Yii::t('hipanel:hosting', 'Error during the account unblocking'),
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
            'single-validate-form' => [
                'class' => ValidateFormAction::class,
                'validatedInputId' => false
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('hipanel:hosting', 'Account deleting task has been added to queue'),
                'error' => Yii::t('hipanel:hosting', 'An error occurred when trying to delete account')
            ],
            'get-directories-list' => [
                'class' => SearchAction::class,
                'findOptions' => ['with_directories' => true],
                'ajaxResponseFormatter' => function ($action) {
                    $results = [];

                    $model = $action->collection->first;
                    foreach ($model['path'] as $path) {
                        $results[] = ['id' => $path, 'text' => $path];
                    }

                    return $results;
                }
            ],
            'bulk-enable-block' => [
                'class' => SmartUpdateAction::class,
                'scenario' => 'enable-block',
                'success' => Yii::t('hipanel:hosting', 'Hosting accounts were blocked successfully'),
                'error' => Yii::t('hipanel:hosting', 'Error during the hosting accounts blocking'),
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
                                'comment' => $comment
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
                        'blockReasons' => $this->getBlockReasons()
                    ]);
                }
            ],
            'bulk-disable-block' => [
                'class' => SmartUpdateAction::class,
                'scenario' => 'disable-block',
                'success' => Yii::t('hipanel:hosting', 'Hosting accounts were unblocked successfully'),
                'error' => Yii::t('hipanel:hosting', 'Error during the hosting accounts unblocking'),
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
        ];
    }

    public function getStateData()
    {
        return $this->getRefs('state,account', 'hipanel:hosting');
    }

    public function getTypeData()
    {
        return $this->getRefs('type,account', 'hipanel:hosting');
    }
}
