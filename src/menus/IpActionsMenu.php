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

use hipanel\widgets\AjaxModal;
use Yii;
use yii\helpers\Html;
use yii\web\JsExpression;

class IpActionsMenu extends \hiqdev\yii2\menus\Menu
{
    public $model;

    public function run($config = [])
    {
        $script = $this->registerClientScript();

        return $script . parent::run($config);
    }

    public function items()
    {
        return [
            'view' => [
                'label' => Yii::t('hipanel', 'View'),
                'icon' => 'fa-info',
                'url' => ['@ip/view', 'id' => $this->model->id],
            ],
            'expand' => [
                'label' => Yii::t('hipanel:hosting', 'Expand'),
                'icon' => 'fa-th',
                'url' => ['@ip/expand', 'id' => $this->model->id],
                'linkOptions' => [
                    'class' => 'btn-expand-ip',
                    'data-id' => $this->model->id,
                    'data-pjax' => 0,
                ],
            ],
            'update' => [
                'label' => Yii::t('hipanel', 'Update'),
                'icon' => 'fa-pencil',
                'url' => ['@ip/update', 'id' => $this->model->id],
                'visible' => Yii::$app->user->can('admin'),
            ],
//            'delete' => [
//                'label' => Yii::t('hipanel', 'Delete'),
//                'icon' => 'fa-trash',
//                'url' => ['@ip/delete', 'id' => $this->model->id],
//                'linkOptions' => [
//                    'data' => [
//                        'confirm' => Yii::t('hipanel', 'Are you sure you want to delete this item?'),
//                        'method' => 'POST',
//                        'pjax' => '0',
//                    ],
//                ],
//            ],
        ];
    }

    public function registerClientScript()
    {
        $this->getView()->registerJs("$(document).on('click', '.btn-expand-ip', function (event) {
            $('#expand-ip').data('ip_id', $(this).data('id')).modal('show');
            event.preventDefault();
        });");

        return AjaxModal::widget([
            'id' => 'expand-ip',
            'header' => Html::tag('h4', Yii::t('hipanel:hosting', 'Expanded range'), ['class' => 'modal-title']),
            'scenario' => 'expand',
            'actionUrl' => ['expand'],
            'size' => AjaxModal::SIZE_LARGE,
            'toggleButton' => false,
            'clientEvents' => [
                'show.bs.modal' => function ($widget) {
                    return new JsExpression("function() {
                        $.get('{$widget->actionUrl}', {'id': $('#{$widget->id}').data('ip_id')}).done(function (data) {
                            $('#{$widget->id} .modal-body').html(data);
                        });;
                    }");
                },
            ],
        ]);
    }
}
