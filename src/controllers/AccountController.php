<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\SearchAction;
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\helpers\ArrayHelper;
use hipanel\models\Ref;
use Yii;

class AccountController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::class,
                'data' => function ($action) {
                    return [
                        'stateData' => $action->controller->getStateData(),
                        'typeData' => $action->controller->getTypeData(),
                    ];
                }
            ],
            'view' => [
                'class' => ViewAction::class,
                'findOptions' => [
                    'with_mail_settings' => true
                ],
                'data' => function ($action) {
                    return [
                        'blockReasons' => $action->controller->getBlockReasons()
                    ];
                }
            ],
            'create' => [
                'class' => SmartCreateAction::class,
                'success' => Yii::t('app', 'Account creating task has been added to queue'),
                'error' => Yii::t('app', 'An error occurred when trying to create account')
            ],
            'create-ftponly' => [
                'class' => SmartCreateAction::class,
                'success' => Yii::t('app', 'Account creating task has been added to queue'),
                'error' => Yii::t('app', 'An error occurred when trying to create account')
            ],
            'set-password' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('app', 'Password changed'),
                'error' => Yii::t('app', 'Failed to change password'),
            ],
            'set-allowed-ips' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('app', 'Allowed IPs changing task has been successfully added to queue'),
                'error' => Yii::t('app', 'An error occurred when trying to change allowed IPs'),
            ],
            'set-mail-settings' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('app', 'Mail settings where changed'),
                'error' => Yii::t('app', 'An error occurred when trying to change mail settings'),
            ],
            'enable-block' => [
                'class' => SmartUpdateAction::class,
                'success' => 'Account was blocked successfully',
                'error' => 'Error during the account blocking',
            ],
            'disable-block' => [
                'class' => SmartUpdateAction::class,
                'success' => 'Account was unblocked successfully',
                'error' => 'Error during the account unblocking',
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('app', 'Account deleting task has been added to queue'),
                'error' => Yii::t('app', 'An error occurred when trying to delete account')
            ],
            'get-directories-list' => [
                'class' => SearchAction::class,
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
