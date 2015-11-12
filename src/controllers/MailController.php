<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\models\Ref;
use Yii;

class MailController extends \hipanel\base\CrudController
{
    public function actions() {
        return [
            'search' => [
                'class' => 'hipanel\actions\SearchAction'
            ],
            'index' => [
                'class' => 'hipanel\actions\IndexAction',
                'data' => function ($action) {
                    return [
                        'stateData' => $action->controller->getStateData(),
                        'typeData' => $action->controller->getTypeData(),
                    ];
                }
            ],
            'create' => [
                'class' => 'hipanel\actions\SmartCreateAction',
                'success' => Yii::t('app', 'Mailbox creating task has been added to queue'),
                'error' => Yii::t('app', 'An error occurred when trying to create mailbox')
            ],
            'validate-form' => [
                'class' => 'hipanel\actions\ValidateFormAction',
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
