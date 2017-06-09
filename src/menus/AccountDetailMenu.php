<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\menus;

use hipanel\widgets\BlockModalButton;
use hipanel\widgets\SettingsModal;
use hipanel\widgets\SimpleOperation;
use Yii;

class AccountDetailMenu extends \hipanel\menus\AbstractDetailMenu
{
    public $model;

    public $blockReasons = [];

    public function items()
    {
        return [
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel', 'Change password'),
                    'headerOptions' => ['class' => 'label-danger'],
                    'icon' => 'fa-key fa-flip-horizontal fa-fw',
                    'scenario' => 'change-password',
                ]),
                'encode' => false,
                'visible' => true,
            ],
           [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel:hosting', 'IP address restrictions'),
                    'headerOptions' => ['class' => 'label-warning'],
                    'icon' => 'fa-arrows-alt fa-fw',
                    'scenario' => 'set-allowed-ips',
                ]),
                'encode' => false,
                'visible' => true,
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel:hosting', 'Mail settings'),
                    'headerOptions' => ['class' => 'label-info'],
                    'icon' => 'fa-envelope fa-fw',
                    'scenario' => 'mailing-settings',
                ]),
                'encode' => false,
                'visible' => $this->model->canSetMailSettings(),
            ],
            [
                'label' => BlockModalButton::widget(['model' => $this->model]),
                'encode' => false,
                'visible' => Yii::$app->user->can('support') && Yii::$app->user->id !== $this->model->client_id,
            ],
            'delete' => [
                'label' => SimpleOperation::widget([
                    'model' => $this->model,
                    'scenario' => 'delete',
                    'skipCheckOperable' => true,
                    'buttonLabel' => '<i class="fa fa-fw fa-trash-o"></i>' . Yii::t('hipanel', 'Delete'),
                    'buttonClass' => '',
                    'body' => Yii::t('hipanel:hosting:account', 'Are you sure you want to delete account {name}?', ['name' => $this->model->login]),
                    'modalHeaderLabel' => Yii::t('hipanel:hosting:account', 'Confirm account deleting'),
                    'modalHeaderOptions' => ['class' => 'label-danger'],
                    'modalFooterLabel' => Yii::t('hipanel:hosting:account', 'Delete account'),
                    'modalFooterLoading' => Yii::t('hipanel:hosting:account', 'Deleting account'),
                    'modalFooterClass' => 'btn btn-danger',
                ]),
                'encode' => false,
                'visible' => true,
            ],
        ];
    }

    public function getViewPath()
    {
        return '@vendor/hiqdev/hipanel-module-hosting/src/views/account';
    }
}
