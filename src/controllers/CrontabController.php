<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

/**
 * @see    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\filters\EasyAccessControl;
use hipanel\modules\hosting\models\Crontab;
use hipanel\actions\RenderJsonAction;
use hipanel\actions\RedirectAction;
use Yii;
use yii\base\Exception;
use yii\web\Response;

class CrontabController extends \hipanel\base\CrudController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => EasyAccessControl::class,
                'actions' => [
                    'update' => 'crontab.update',
                    '*' => Yii::$app->params['module.hosting.is_public'] || Yii::$app->user->can('support')
                        ? 'crontab.read'
                        : false,
                ],
            ],
        ]);
    }

    public function actions()
    {
        return array_merge(parent::actions(), [
            'index' => [
                'class' => IndexAction::class,
                'filterStorageMap' => [
                    'server' => 'server.server.name',
                    'account' => 'hosting.account.login',
                    'client_id' => 'client.client.id',
                ],
            ],
            'view' => [
                'class' => ViewAction::class,
            ],
            'update' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:hosting', 'Success'),
                'POST ajax' => [
                    'save' => true,
                    'success' => [
                        'class' => RedirectAction::class,
                        'url' => function ($action) {
                            return ['@crontab/index'];
                        },
                    ],
                ],
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
        ]);
    }

    public function actionRequestFetch()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $response = [];
        $id = Yii::$app->request->post('id');
        if ($id) {
            try {
                $response = Crontab::perform('request-fetch', ['id' => $id]);
            } catch (Exception $e) {
                $response['error'] = $e->errorInfo['response'];
            }
        }

        return $response;
    }

    public function actionGetRequestState()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = [];
        $id = Yii::$app->request->post('id');
        if ($id) {
            try {
                $response = Crontab::perform('get-request-state', ['id' => $id]);
            } catch (Exception $e) {
                $response['error'] = $e->errorInfo['response'];
            }
        }

        return $response;
    }

    public function actionGetInfo($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = [];
        if ($id) {
            try {
                $response = Crontab::perform('get-info', ['id' => $id]);
            } catch (Exception $e) {
                $response = $e->errorInfo['response'];
            }
        }

        return $response;
    }
}
