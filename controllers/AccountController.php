<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use Yii;

class AccountController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'create'          => [
                'class'                 => 'hipanel\actions\SwitchAction',
                'success'               => Yii::t('app', 'Account create task has been created successfully'),
                'error'                 => Yii::t('app', 'Error while creating account'),
                'scenario'              => 'create-user',
                'GET html | GET pjax'   => [
                    'class'  => 'hipanel\actions\RenderAction',
                    'view'   => 'create',
                    'params' => [
                        'model' => function ($action) {
                            return $action->controller->newModel(['scenario' => 'create-user']);
                        },
                    ],
                ],
                'POST html | POST pjax' => [
                    'save'    => true,
                    'success' => [
                        'class' => 'hipanel\actions\RedirectAction',
                        'url'   => function ($action, $model) {
                            return ['view', 'id' => $model->id];
                        }
                    ],
                    'error'   => [
                        'class'  => 'hipanel\actions\RenderAction',
                        'view'   => 'create',
                        'params' => [
                            'model' => function ($action, $model) {
                                return $model;
                            },
                            'type'  => 'user'
                        ],
                    ],
                ],
            ],
            'create-ftponly'  => [
                'class'                 => 'hipanel\actions\SwitchAction',
                'success'               => Yii::t('app', 'Account create task has been created successfully'),
                'error'                 => Yii::t('app', 'Error while creating account'),
                'GET html | GET pjax'   => [
                    'class'  => 'hipanel\actions\RenderAction',
                    'view'   => 'create',
                    'params' => [
                        'model' => function ($action) {
                            return $action->controller->newModel(['scenario' => 'create-ftponly']);
                        }
                    ],
                ],
                'POST html | POST pjax' => [
                    'save'    => true,
                    'success' => [
                        'class' => 'hipanel\actions\RedirectAction',
                        'url'   => function ($action, $model) {
                            return ['view', 'id' => $model->id];
                        }
                    ],
                    'error'   => [
                        'class'  => 'hipanel\actions\RenderAction',
                        'view'   => 'create',
                        'params' => [
                            'model' => function ($action, $model) {
                                return $model;
                            }
                        ],
                    ],
                ],
            ],
            'set-password'    => [
                'class'                 => 'hipanel\actions\SwitchAction',
                'success'               => Yii::t('app', 'Password changing task has been successfully added to queue'),
                'error'                 => Yii::t('app', 'An error occurred when trying to change password'),
                'POST html | POST pjax' => [
                    'save'    => true,
                    'success' => [
                        'class' => 'hipanel\actions\RedirectAction',
                        'url'   => function ($action, $model) {
                            return ['view', 'id' => $model->id];
                        }
                    ]
                ],
            ],
            'set-allowed-ips' => [
                'class'                 => 'hipanel\actions\SwitchAction',
                'success'               => Yii::t('app', 'Allowed IPs changing task has been successfully added to queue'),
                'error'                 => Yii::t('app', 'An error occurred when trying to change allowed IPs'),
                'POST html | POST pjax' => [
                    'save'    => true,
                    'success' => [
                        'class' => 'hipanel\actions\RedirectAction',
                        'url'   => function ($action, $model) {
                            return ['view', 'id' => $model->id];
                        }
                    ]
                ],
            ],
        ];
    }
}
