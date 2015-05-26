<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\base\CrudController;
use yii\filters\VerbFilter;
use Yii;

class DbController extends CrudController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'create' => ['get', 'post']
                ]
            ]
        ];
    }

    public function actions()
    {
        return [
            'delete'       => [
                'class'     => 'hipanel\actions\SwitchAction',
                'success'   => Yii::t('app', 'DB delete task has been created successfully'),
                'error'     => Yii::t('app', 'Error while deleting DB'),
                'POST' => [
                    'save'    => true,
                    'success' => [
                        'class' => 'hipanel\actions\RedirectAction',
                        'url'   => ['index'],
                    ],
                    'error'   => [
                        'class' => 'hipanel\actions\RedirectAction',
                        'url'   => function ($action, $model) {
                            return ['view', 'id' => $model->id];
                        }
                    ]
                ],
            ],
            'create'       => [
                'class'               => 'hipanel\actions\SwitchAction',
                'success'             => Yii::t('app', 'DB create task has been created successfully'),
                'error'               => Yii::t('app', 'Error while creating DB'),
                'GET html | GET pjax' => [
                    'class'  => 'hipanel\actions\RenderAction',
                    'view'   => 'create',
                    'params' => [
                        'model' => function ($action) {
                            return $action->controller->newModel(['scenario' => 'create']);
                        }
                    ],
                ],
                'POST html'           => [
                    'save'    => true,
                    'flash'   => true,
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
            'set-password' => [
                'class'   => 'hipanel\actions\SwitchAction',
                'success' => Yii::t('app', 'DB password change task has been created successfully'),
                'error'   => Yii::t('app', 'Error while DB password changing'),
                'POST'    => [
                    'save'    => true,
                    'success' => [
                        'class'  => 'hipanel\actions\ProxyAction',
                        'action' => 'view',
                        'params' => function ($action, $model) {
                            return ['id' => $model->id];
                        },
                    ]
                ],
            ],
            'truncate'     => [
                'class'   => 'hipanel\actions\SwitchAction',
                'success' => Yii::t('app', 'DB truncate task has been created successfully'),
                'error'   => Yii::t('app', 'Error while truncating DB'),
                'POST'    => [
                    'save'    => true,
                    'success' => [
                        'class'  => 'hipanel\actions\ProxyAction',
                        'action' => 'view',
                        'params' => function ($action, $model) {
                            return ['id' => $model->id];
                        }
                    ],
                ]
            ]
        ];
    }
}
