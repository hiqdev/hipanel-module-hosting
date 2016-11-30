<?php

namespace hipanel\modules\hosting\menus;

use hipanel\widgets\ModalButton;
use hiqdev\menumanager\Menu;
use Yii;
use yii\helpers\Html;

class MailDetailMenu extends Menu
{
    public $model;

    public function items()
    {
        return [
            [
                'label' => Yii::t('hipanel', 'Update'),
                'icon' => 'fa-pencil',
                'url' => ['update', 'id' => $this->model->id],
            ],
            [
                'label' => $this->renderView('_change-password', ['model' => $this->model]),
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
                        ]
                    ],
                    'body' => Yii::t('hipanel:hosting',
                        'Are you sure to delete mail {name}?',
                        ['name' => Html::tag('b', $this->model->mail)]
                    )
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
