<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\models\Ref;
use Yii;

class HdomainController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'hipanel\actions\IndexAction',
                'findOptions' => ['with_aliases' => true, 'with_vhosts' => true, 'with_request' => true],
                'data' => function ($action) {
                    return [
                        'stateData' => $action->controller->getStateData(),
                        'typeData' => $action->controller->getTypeData(),
                    ];
                }
            ],
            'view' => [
                'class' => 'hipanel\actions\ViewAction',
                'findOptions' => ['with_aliases' => true, 'with_vhosts' => true, 'with_request' => true, 'show_deleted' => true, 'show_aliases' => true],
            ],
            'create' => [
                'class' => 'hipanel\actions\SmartCreateAction',
                'success' => Yii::t('app', 'Account create task has been created successfully'),
                'error' => Yii::t('app', 'Error while creating account'),
            ],
            'validate-form' => [
                'class' => 'hipanel\actions\ValidateFormAction',
            ],
            // Premium Autorenewal
            'enable-paid-feature-autorenewal' => [
                'class' => 'hipanel\actions\SmartPerformAction',
                'success' => Yii::t('app', 'Premium autorenewal has been enabled'),
            ],
            'disable-paid-feature-autorenewal' => [
                'class' => 'hipanel\actions\SmartPerformAction',
                'success' => Yii::t('app', 'Premium autorenewal has been disabled'),
            ],
        ];
    }

    public function getStateData()
    {
        return Ref::getList('state,hdomain');
    }

    public function getTypeData()
    {
        return [
            0 => Yii::t('app', 'Domain'),
            1 => Yii::t('app', 'Alias'),
        ];
    }
}
