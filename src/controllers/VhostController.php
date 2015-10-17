<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\helpers\ArrayHelper;
use Yii;

class VhostController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'hipanel\actions\IndexAction',
            ],
            'view' => [
                'class' => 'hipanel\actions\RedirectAction',
                'url' => ArrayHelper::merge(['@hdomain/view'], Yii::$app->request->get())
            ],
            'advanced-config' => [
                'class' => 'hipanel\actions\SmartUpdateAction',
                'findOptions' => [
                    'select' => 'advanced',
                ],
                'success' => Yii::t('app', 'Advanced settings was updated successfully'),
                'error'   => Yii::t('app', 'Error while advanced settings update'),
            ],
            'manage-proxy' => [
                'class' => 'hipanel\actions\SmartUpdateAction',
                'findOptions' => [
                    'select' => 'advanced',
                    'with_backends' => true
                ],
                'success' => Yii::t('app', 'Domain proxy setting settings changed'),
                'error' => Yii::t('app', 'Error while changing domain proxy settings'),
            ],
            'validate-form' => [
                'class' => 'hipanel\actions\ValidateFormAction',
            ],
        ];
    }
}
