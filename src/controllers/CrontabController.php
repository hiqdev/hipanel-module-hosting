<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\modules\hosting\models\Crontab;
use Yii;
use yii\base\Exception;
use yii\web\Response;

class CrontabController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'hipanel\actions\IndexAction',
            ],
            'view' => [
                'class' => 'hipanel\actions\ViewAction',
            ],
            'update' => [
                'class' => 'hipanel\actions\SmartUpdateAction',
            ],
            'validate-form' => [
                'class' => 'hipanel\actions\ValidateFormAction',
            ],
        ];
    }

    public function actionRequestFetch()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $response = [];
        $id = Yii::$app->request->post('id');
        if ($id) {
            try {
                $response = Crontab::perform('RequestFetch', ['id' => $id]);
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
                $response = Crontab::perform('GetRequestState', ['id' => $id]);
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
                $response = Crontab::perform('GetInfo', ['id' => $id]);
            } catch (Exception $e) {
                $response = $e->errorInfo['response'];
            }

        }
        return $response;
    }
}
