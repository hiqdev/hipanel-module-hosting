<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\OrientationAction;
use hipanel\actions\RedirectAction;
use hipanel\actions\SearchAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\helpers\ArrayHelper;
use Yii;

class VhostController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'set-orientation' => [
                'class' => OrientationAction::class,
                'allowedRoutes' => [
                    '/hosting/vhost/index'
                ]
            ],
            'index' => [
                'class' => RedirectAction::class,
                'url' => ['@hdomain/index']
            ],
            'search' => [
                'class' => SearchAction::class,
            ],
            'view' => [
                'class' => RedirectAction::class,
                'url' => ArrayHelper::merge(['@hdomain/view'], Yii::$app->request->get())
            ],
            'advanced-config' => [
                'class' => SmartUpdateAction::class,
                'findOptions' => [
                    'select' => 'advanced',
                ],
                'success' => Yii::t('app', 'Advanced settings was updated successfully'),
                'error'   => Yii::t('app', 'Error while advanced settings update'),
            ],
            'manage-proxy' => [
                'class' => SmartUpdateAction::class,
                'findOptions' => [
                    'select' => 'advanced',
                    'with_backends' => true
                ],
                'success' => Yii::t('app', 'Domain proxy setting settings changed'),
                'error' => Yii::t('app', 'Error while changing domain proxy settings'),
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
        ];
    }
}
