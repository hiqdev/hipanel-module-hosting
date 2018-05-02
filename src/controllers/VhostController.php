<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

/**
 * @see    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\actions\ComboSearchAction;
use hipanel\actions\RedirectAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\helpers\ArrayHelper;
use hipanel\filters\EasyAccessControl;
use Yii;

class VhostController extends \hipanel\base\CrudController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => EasyAccessControl::class,
                'actions' => [
                    'advanced-config,manage-proxy' => 'account.update',
                    '*' => 'account.read',
                ],
            ],
        ]);
    }

    public function actions()
    {
        return array_merge(parent::actions(), [
            'index' => [
                'class' => RedirectAction::class,
                'url' => ['@hdomain/index'],
            ],
            'search' => [
                'class' => ComboSearchAction::class,
            ],
            'view' => [
                'class' => RedirectAction::class,
                'url' => ArrayHelper::merge(['@hdomain/view'], Yii::$app->request->get()),
            ],
            'advanced-config' => [
                'class' => SmartUpdateAction::class,
                'findOptions' => [
                    'select' => 'advanced',
                ],
                'success' => Yii::t('hipanel:hosting', 'Advanced settings were updated successfully'),
                'error'   => Yii::t('hipanel:hosting', 'Error when updating advanced settings'),
            ],
            'manage-proxy' => [
                'class' => SmartUpdateAction::class,
                'findOptions' => [
                    'select' => 'advanced',
                    'with_backends' => true,
                ],
                'success' => Yii::t('hipanel:hosting', 'Domain proxy setting settings were changed'),
                'error' => Yii::t('hipanel:hosting', 'Error when changing domain proxy settings'),
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
        ]);
    }
}
