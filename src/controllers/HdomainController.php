<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use Yii;

class HdomainController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'index'  => [
                'class'       => 'hipanel\actions\IndexAction',
                'findOptions' => ['with_aliases' => true, 'with_vhosts' => true, 'with_request' => true]
            ],
            'view'   => [
                'class'       => 'hipanel\actions\ViewAction',
                'findOptions' => [
                    'with_aliases' => true,
                    'with_vhosts'  => true,
                    'with_request' => true
                ]
            ],
            'create' => [
                'class'   => 'hipanel\actions\SmartCreateAction',
                'success' => Yii::t('app', 'Account create task has been created successfully'),
                'error'   => Yii::t('app', 'Error while creating account'),
            ],
            'validate-form'   => [
                'class' => 'hipanel\actions\ValidateFormAction',
            ],
        ];
    }
}
