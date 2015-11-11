<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\models\Ref;

class MailController extends \hipanel\base\CrudController
{
    public function actions() {
        return [
            'index' => [
                'class' => 'hipanel\actions\IndexAction',
                'data' => function ($action) {
                    return [
                        'stateData' => $action->controller->getStateData(),
                        'typeData' => $action->controller->getTypeData(),
                    ];
                }
            ]
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
