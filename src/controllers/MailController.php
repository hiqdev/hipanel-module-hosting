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
use hipanel\models\Ref;
use Yii;

class MailController extends \hipanel\base\CrudController
{
    public function actions() {
        return [
            'search' => [
                'class' => SearchAction::class
            ],
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
                'class' => ViewAction::class
            ],
            'create' => [
                'class' => SmartCreateAction::class,
                'success' => Yii::t('app', 'Mailbox creating task has been added to queue'),
                'error' => Yii::t('app', 'An error occurred when trying to create mailbox')
            ],
            'update' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('app', 'Mailbox updating task has been added to queue'),
                'error' => Yii::t('app', 'An error occurred when trying to update mailbox')
            ],
            'set-password' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('app', 'Mailbox password change task has been added to queue'),
                'error' => Yii::t('app', 'An error occurred when trying to change mailbox password')
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('app', 'Mailbox delete task has been created successfully'),
                'error' => Yii::t('app', 'An error occurred when trying to delete mailbox')
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
        ];
    }

    public function getStateData()
    {
        return Ref::getList('state,mail');
    }

    public function getTypeData()
    {
        return Ref::getList('type,mail');
    }
}
