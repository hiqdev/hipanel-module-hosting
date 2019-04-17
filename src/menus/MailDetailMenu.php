<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\menus;

use hipanel\widgets\ModalButton;
use Yii;
use yii\helpers\Html;

class MailDetailMenu extends \hipanel\menus\AbstractDetailMenu
{
    public $model;

    public function items()
    {
        return [
            [
                'label' => Yii::t('hipanel', 'Update'),
                'icon' => 'fa-pencil',
                'url' => ['update', 'id' => $this->model->id],
                'visible' => $this->model->state !== 'deleted',
            ],
            [
                'label' => $this->render('_change-password', ['model' => $this->model]),
                'encode' => false,
                'visible' => $this->model->canChangePassword(),
            ],
            [
                'label' => ModalButton::widget([
                    'model' => $this->model,
                    'scenario' => 'delete',
                    'button' => [
                        'label' => '<i class="fa fa-fw fa-trash-o"></i> ' . Yii::t('hipanel', 'Delete'),
                    ],
                    'modal' => [
                        'header' => Html::tag('h4', Yii::t('hipanel:hosting', 'Confirm mailbox deleting')),
                        'headerOptions' => ['class' => 'label-danger'],
                        'footer' => [
                            'label' => Yii::t('hipanel:hosting', 'Delete mailbox'),
                            'data-loading-text' => Yii::t('hipanel', 'Deleting...'),
                            'class' => 'btn btn-danger',
                        ],
                    ],
                    'body' => Yii::t('hipanel:hosting',
                        'Are you sure to delete mail {name}?',
                        ['name' => Html::tag('b', $this->model->mail)]
                    ),
                ]),
                'encode' => false,
            ],
        ];
    }

    public function getViewPath()
    {
        return '@vendor/hiqdev/hipanel-module-hosting/src/views/mail';
    }
}
