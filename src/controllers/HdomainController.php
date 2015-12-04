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
use hipanel\actions\SmartPerformAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\models\Ref;
use Yii;

class HdomainController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'search' => [
                'class' => SearchAction::class,
            ],
            'index' => [
                'class' => IndexAction::class,
                'findOptions' => [
                    'with_vhosts' => true,
                    'with_aliases' => true,
                    'with_request' => true,
                ],
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
                    'with_vhosts' => true,
                    'with_aliases' => true,
                    'with_request' => true,
                    'show_deleted' => true,
                    'show_aliases' => true,
                ],
                'data' => function ($action) {
                    return [
                        'blockReasons' => $action->controller->getBlockReasons()
                    ];
                }
            ],
            'create' => [
                'class' => SmartCreateAction::class,
                'success' => Yii::t('app', 'Domain create task has been created successfully'),
                'error' => Yii::t('app', 'Error while creating domain'),
            ],
            'create-alias' => [
                'class' => SmartCreateAction::class,
                'view' => 'create-alias',
                'success' => Yii::t('app', 'Domain alias create task has been created successfully'),
                'error' => Yii::t('app', 'Error while creating domain'),
            ],
            'enable-block' => [
                'class' => SmartUpdateAction::class,
                'success' => 'Hosting domain was blocked successfully',
                'error' => 'Error during the hosting domain blocking',
            ],
            'disable-block' => [
                'class' => SmartUpdateAction::class,
                'success' => 'Hosting domain was unblocked successfully',
                'error' => 'Error during the hosting domain unblocking',
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
            'enable-paid-feature-autorenewal' => [
                'class' => SmartPerformAction::class,
                'success' => Yii::t('app', 'Premium autorenewal has been enabled'),
            ],
            'disable-paid-feature-autorenewal' => [
                'class' => SmartPerformAction::class,
                'success' => Yii::t('app', 'Premium autorenewal has been disabled'),
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('app', 'Domain delete task has been created successfully'),
                'error'   => Yii::t('app', 'Error while deleting domain'),
            ],
            'delete-alias' => [
                'class' => SmartDeleteAction::class,
                'scenario' => 'delete',
                'success' => Yii::t('app', 'Alias delete task has been created successfully'),
                'error'   => Yii::t('app', 'Error while deleting alias'),
            ]
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
