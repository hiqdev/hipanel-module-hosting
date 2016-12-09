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

use hipanel\widgets\ModalButton;
use hiqdev\menumanager\Menu;
use Yii;
use yii\helpers\Html;

class IpDetailMenu extends Menu
{
    public $model;

    public function items()
    {
        $actions = IpActionsMenu::create(['model' => $this->model])->items();
        $items = array_merge($actions, [
            [
                'label' => ModalButton::widget([
                    'model' => $this->model,
                    'scenario' => 'delete',
                    'button' => [
                        'label' => '<i class="fa fa-fw fa-trash-o"></i> ' . Yii::t('hipanel', 'Delete'),
                    ],
                    'modal' => [
                        'header' => Html::tag('h4', Yii::t('hipanel:hosting', 'Confirm IP address deleting')),
                        'headerOptions' => ['class' => 'label-danger'],
                        'footer' => [
                            'label' => Yii::t('hipanel:hosting', 'Delete IP address'),
                            'data-loading-text' => Yii::t('hipanel:hosting', 'Deleting IP address...'),
                            'class' => 'btn btn-danger',
                        ],
                    ],
                    'body' => Yii::t('hipanel:hosting',
                        'Are you sure, that you want to delete IP address {ip}? All related objects might be deleted too!',
                        ['ip' => Html::tag('b', $this->model->ip)]
                    ),
                ]),
                'encode' => false,
                'visible' => Yii::$app->user->can('admin'),
            ],
        ]);
        unset($items['view']);

        return $items;
    }
}
