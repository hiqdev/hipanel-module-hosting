<?php

namespace hipanel\modules\hosting\menus;

use hipanel\widgets\ModalButton;
use hiqdev\menumanager\Menu;
use Yii;
use yii\helpers\Html;
use yii\helpers\StringHelper;

class HdomainDetailMenu extends Menu
{
    public $model;

    public $blockReasons = [];

    public function items()
    {
        $url = 'http://' . $this->model->domain . '/';

        return [
            [
                'label' => Yii::t('hipanel:hosting', 'Go to site {link}', ['link' => StringHelper::truncate($url, 15)]),
                'icon' => 'fa-paper-plane',
                'url' => $url,
                'encode' => false,
                'linkOptions' => [
                    'target' => '_blank',
                ],
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'Advanced settings'),
                'icon' => 'fa-pencil',
                'url' => ['/hosting/vhost/advanced-config', 'id' => $this->model->id],
                'visible' => !$this->model->isAlias(),
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'Proxy settings'),
                'icon' => 'fa-adjust',
                'url' => ['/hosting/vhost/manage-proxy', 'id' => $this->model->id],
                'visible' => !$this->model->isAlias(),
            ],
            [
                'label' => $this->renderView('_block', ['model' => $this->model, 'blockReasons' => $this->blockReasons]),
                'encode' => false,
                'visible' => Yii::$app->user->can('support') && Yii::$app->user->id !== $this->model->client_id && !$this->model->isAlias(),
            ],
            [
                'label' => ModalButton::widget([
                    'model' => $this->model,
                    'scenario' => 'delete',
                    'button' => [
                        'label' => '<i class="fa fa-fw fa-trash-o"></i> ' . Yii::t('hipanel', 'Delete'),
                    ],
                    'modal' => [
                        'header' => Html::tag('h4', Yii::t('hipanel:hosting', 'Confirm domain deleting')),
                        'headerOptions' => ['class' => 'label-danger'],
                        'footer' => [
                            'label' => Yii::t('hipanel:hosting', 'Delete domain'),
                            'data-loading-text' => Yii::t('hipanel', 'Deleting...'),
                            'class' => 'btn btn-danger',
                        ]
                    ],
                    'body' => Yii::t('hipanel:hosting',
                        'Are you sure to delete domain {name}? All files under domain root on the server will stay untouched. You can delete them manually later.',
                        ['name' => $this->model->domain]
                    )
                ]),
                'encode' => false,
            ],
        ];
    }

    public function getViewPath()
    {
        return '@vendor/hiqdev/hipanel-module-hosting/src/views/hdomain';
    }
}
