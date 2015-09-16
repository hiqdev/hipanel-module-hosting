<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\helpers\ArrayHelper;
use hipanel\models\Ref;
use Yii;

class AccountController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'hipanel\actions\IndexAction',
                'data' => function ($action) {
                    return [
                        'stateData' => $action->controller->getStateData(),
                        'typeData' => $action->controller->getTypeData(),
                    ];
                }
            ],
            'view' => [
                'class' => 'hipanel\actions\ViewAction',
                'findOptions' => [
                    'with_mail_settings' => true
                ]
            ],
            'create' => [
                'class' => 'hipanel\actions\SmartCreateAction',
                'success' => Yii::t('app', 'Account creating task has been added to queue'),
                'error' => Yii::t('app', 'An error occurred when trying to create account')
            ],
            'create-ftponly' => [
                'class' => 'hipanel\actions\SmartCreateAction',
                'success' => Yii::t('app', 'Account creating task has been added to queue'),
                'error' => Yii::t('app', 'An error occurred when trying to create account')
            ],
            'set-password' => [
                'class' => 'hipanel\actions\SmartUpdateAction',
                'success' => Yii::t('app', 'Password changed'),
                'error' => Yii::t('app', 'Failed to change password'),
            ],
            'set-allowed-ips' => [
                'class' => 'hipanel\actions\SmartUpdateAction',
                'success' => Yii::t('app', 'Allowed IPs changing task has been successfully added to queue'),
                'error' => Yii::t('app', 'An error occurred when trying to change allowed IPs'),
            ],
            'set-mail-settings' => [
                'class' => 'hipanel\actions\SmartUpdateAction',
                'success' => Yii::t('app', 'Mail settings where changed'),
                'error' => Yii::t('app', 'An error occurred when trying to change mail settings'),
            ],
            'validate-form' => [
                'class' => 'hipanel\actions\ValidateFormAction',
            ],
            'delete' => [
                'class' => 'hipanel\actions\SmartDeleteAction',
                'success' => Yii::t('app', 'Account deleting task has been added to queue'),
                'error' => Yii::t('app', 'An error occurred when trying to delete account')
            ],
            'get-directories-list' => [
                'class' => 'hipanel\actions\SearchAction',
                'findOptions' => ['with_directories' => true],
                'ajaxResponseFormatter' => function ($action) {
                    $results = [];

                    $model = $action->collection->first;
                    foreach ($model['path'] as $path) {
                        $results[] = ['id' => $path, 'text' => $path];
                    }

                    return $results;
                }
            ]
        ];
    }

    public function getStateData()
    {
        return Ref::getList('state,account');
    }

    public function getTypeData()
    {
        return Ref::getList('type,account');
    }
}
