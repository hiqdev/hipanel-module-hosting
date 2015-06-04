<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\helpers\ArrayHelper;
use Yii;

class HdomainController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'create' => [
                'class'                 => 'hipanel\actions\SwitchAction',
                'success'               => Yii::t('app', 'Account create task has been created successfully'),
                'error'                 => Yii::t('app', 'Error while creating account'),
                'GET html | GET pjax'   => [
                    'class'  => 'hipanel\actions\RenderAction',
                    'view'   => 'create',
                    'params' => [
                        'model' => function ($action) {
                            return $action->controller->newModel(['scenario' => 'create']);
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
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel                      = static::searchModel();
        $params                           = Yii::$app->request->queryParams;
        $params[$searchModel->formName()] = ArrayHelper::merge($params[$searchModel->formName()],
            ['with_aliases' => true, 'with_vhosts' => true, 'with_request' => true]);
        $dataProvider                     = $searchModel->search($params);

        return $this->render('index', compact('searchModel', 'dataProvider'));
    }
}
