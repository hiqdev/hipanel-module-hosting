<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\base\CrudController;
use Yii;
use yii\filters\VerbFilter;

class DBController extends CrudController
{
    public function behaviors () {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'create' => ['get', 'post']
                ]
            ]
        ];
    }

    public function actionCreate () {
        $model = $this->newModel(['scenario' => 'create']);

        return $this->perform([
            'success' => [
                'result' => [
                    'POST html' => ['redirect', function ($m) { return $m->id; }, 'addFlash' => true],
                    'POST pjax' => [
                        'action',
                        ['view', function ($m) { return $m->id; }],
                        'setUrl'   => function ($m) { return ['view', 'id' => $m->id]; },
                        'addFlash' => true
                    ]
                ]
            ],
            'result'  => [
                'GET html' => ['render', ['create', ['model' => $model]]]
            ],
        ]);

    }

    public function actionDelete () {
        return $this->perform([
            'success' => [
                'message' => Yii::t('app', 'DB deleting task has been created successfully'),
                'result'  => [
                    'POST pjax' => [
                        'action',
                        ['index'],
                        'addFlash'  => true,
                        'changeUrl' => function ($model) {
                            return ['index'];
                        }
                    ]
                ],
            ],
            'error'   => [
                'message' => Yii::t('app', 'Error while deleting DB'),
                'result'  => [
                    'POST pjax' => ['action', ['view', function ($model) { return ['id' => $model->id]; }], 'addFlash' => true]
                ],
            ],
        ]);
    }

    public function actionSetPassword () {
        return $this->perform([
            'result' => [ ///
                          'POST pjax' => ['action', ['view', function ($model) { return ['id' => $model->id]; }], 'addFlash' => true]
            ],
        ]);
    }

    public function actionTruncate () {
        return $this->perform([
            'success'  => [
                'message' => Yii::t('app', 'DB truncate task has been created successfully'),
            ],
            'error'    => [
                'message' => Yii::t('app', 'Error while truncating DB'),
            ],
            'result'   => [
                'pjax'       => ['action', ['view', function ($model) { return ['id' => $model->id]; }]],
                'html'       => ['render', ['create', function ($model) { return ['id' => $model->id]; }]],
                'html2'      => ['render', ['create', ['id']]],
                'POST html'  => ['redirect', ['create']],
                'POST html1' => ['redirect', function ($model) { return ['view', 'id' => $model->id]; }],
                'POST html2' => ['redirect', ['view', ['id']]],
                'POST html3' => ['return'],
                'POST html4' => ['renderJson'],
                'POST html5' => ['custom',],
            ],
            'addFlash' => true
        ]);
    }
}
