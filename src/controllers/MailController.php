<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

/**
 * @see    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\actions\ComboSearchAction;
use hipanel\actions\IndexAction;
use hipanel\actions\OrientationAction;
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartPerformAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\modules\hosting\models\Mail;
use Yii;

class MailController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'search' => [
                'class' => ComboSearchAction::class,
            ],
            'index' => [
                'class' => IndexAction::class,
                'data' => function ($action) {
                    return [
                        'stateData' => $action->controller->getStateData(),
                        'typeData' => $action->controller->getTypeData(),
                    ];
                },
                'filterStorageMap' => [
                    'mail_like' => 'hosting.mail.mail_like',
                    'type' => 'hosting.mail.type',
                    'state' => 'hosting.mail.state',
                    'server' => 'server.server.name',
                    'account' => 'hosting.account.login',
                    'client_id' => 'client.client.id',
                    'seller_id' => 'client.client.seller_id',
                ],
            ],
            'view' => [
                'class' => ViewAction::class,
                'findOptions' => [
                    'show_deleted' => true
                ]
            ],
            'create' => [
                'class' => SmartCreateAction::class,
                'success' => Yii::t('hipanel:hosting', 'Mailbox creating task has been added to queue'),
                'error' => Yii::t('hipanel:hosting', 'An error occurred when trying to create mailbox'),
            ],
            'update' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:hosting', 'Mailbox updating task has been added to queue'),
                'error' => Yii::t('hipanel:hosting', 'An error occurred when trying to update mailbox'),
            ],
            'set-password' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:hosting', 'Mailbox password change task has been added to queue'),
                'error' => Yii::t('hipanel:hosting', 'An error occurred when trying to change mailbox password'),
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('hipanel:hosting', 'Mailbox delete task has been created successfully'),
                'error' => Yii::t('hipanel:hosting', 'An error occurred when trying to delete mailbox'),
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
            'disable' => [
                'class' => SmartPerformAction::class,
                'success' => Yii::t('hipanel:hosting', 'Mailbox has been disabled.'),
                'error' => Yii::t('hipanel:hosting', 'An error occurred.'),
            ],
            'enable' => [
                'class' => SmartPerformAction::class,
                'success' => Yii::t('hipanel:hosting', 'Mailbox has been enabled.'),
                'error' => Yii::t('hipanel:hosting', 'An error occurred.'),
            ],
        ];
    }

    public function getStateData()
    {
        return $this->getRefs('state,mail', 'hipanel:hosting');
    }

    public function getTypeData()
    {
        return Mail::getTypes();
    }
}
