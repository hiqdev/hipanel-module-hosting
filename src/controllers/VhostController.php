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
                'class' => 'hipanel\actions\SearchAction',
                'findOptions' => [
                    'select' => 'advanced'
                ],
                'GET html' => [
                    'save' => true,
                    'flash' => false,
                    'success' => [
                        'class' => 'hipanel\actions\RenderAction',
                        'params' => function ($action) {
                            return [
                                'models' => $action->collection->models,
                                'model' => $action->collection->first
                            ];
                        }
                    ]
                ],
                'POST html' => [
                    'class' => 'hipanel\actions\SmartUpdateAction',
                ],
                'success' => Yii::t('app', 'Advanced settings was updated successfully'),
                'error'   => Yii::t('app', 'Error while advanced settings update'), 
            ],
            'validate-form' => [
                'class' => 'hipanel\actions\ValidateFormAction',
            ],
        ];
    }
}
