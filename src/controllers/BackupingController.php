<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\models\Ref;
use Yii;

class BackupingController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'hipanel\actions\IndexAction',
                'data' => function ($action) {
                    return [
                        'stateOptions' => $action->controller->getStateOptions(),
                        'typeOptions' => $action->controller->getTypeOptions(),
                    ];
                },
            ],
            'update' => [
                'class'   => 'hipanel\actions\SmartUpdateAction',
            ],
            'view' => [
                'class' => 'hipanel\actions\ViewAction',
            ],
        ];
    }

    public function getTypeOptions()
    {
        return Ref::getList('type,backuping');
    }
    public function getStateOptions()
    {
        return [
            'ok' => Yii::t('app', 'Ok'),
            'disabled'=> Yii::t('app', 'Disabled'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }
}
