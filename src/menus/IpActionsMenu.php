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

use Yii;

class IpActionsMenu extends \hiqdev\yii2\menus\Menu
{
    public $model;

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
}
