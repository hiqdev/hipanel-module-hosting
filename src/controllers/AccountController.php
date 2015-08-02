<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use Yii;

class AccountController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'create'          => [
                'class'   => 'hipanel\actions\SmartCreateAction',
                'success' => Yii::t('app', 'Account creating task has been added to queue'),
                'error'   => Yii::t('app', 'An error occurred when trying to create account')
            ],
            'create-ftponly'  => [
                'class' => 'hipanel\actions\SmartCreateAction',
                'success' => Yii::t('app', 'Account creating task has been added to queue'),
                'error'   => Yii::t('app', 'An error occurred when trying to create account')
            ],
            'set-password'    => [
                'class'   => 'hipanel\actions\SmartUpdateAction',
                'success' => Yii::t('app', 'Password changed'),
                'error'   => Yii::t('app', 'Failed to change password'),
            ],
            'set-allowed-ips' => [
                'class'   => 'hipanel\actions\SmartUpdateAction',
                'success' => Yii::t('app', 'Allowed IPs changing task has been successfully added to queue'),
                'error'   => Yii::t('app', 'An error occurred when trying to change allowed IPs'),
            ],
            'validate-form'   => [
                'class' => 'hipanel\actions\ValidateFormAction',
            ],
        ];
    }
}
