<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use Yii;

class RequestController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'hipanel\actions\IndexAction',
                'data' => function ($action) {
                    return [
                        'objectOptions' => $action->controller->getObjectOptions(),
                    ];
                },
            ],
            'view' => [
                'class' => 'hipanel\actions\ViewAction',
            ],
            'delete' => [
                'class' => 'hipanel\actions\SmartDeleteAction',
                'success' => Yii::t('hipanel/hosting', 'Backup deleting task has been added to queue'),
                'error' => Yii::t('hipanel/hosting', 'An error occurred when trying to delete backup')
            ],
        ];
    }
}
