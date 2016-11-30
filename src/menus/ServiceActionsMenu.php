<?php

namespace hipanel\modules\hosting\menus;

use hiqdev\menumanager\Menu;
use Yii;

class ServiceActionsMenu extends Menu
{
    public $model;

    public function items()
    {
        return [
            'view' => [
                'label' => Yii::t('hipanel', 'View'),
                'icon' => 'fa-info',
                'url' => ['@service/view', 'id' => $this->model->id],
            ],
            [
                'label' => Yii::t('hipanel', 'Update'),
                'icon' => 'fa-pencil',
                'url' => ['@service/update', 'id' => $this->model->id],
                'visible' => Yii::$app->user->can('admin'),
            ],
        ];
    }
}
