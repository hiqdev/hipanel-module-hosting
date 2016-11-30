<?php

namespace hipanel\modules\hosting\menus;

use hiqdev\menumanager\Menu;
use Yii;

class CrontabActionsMenu extends Menu
{
    public $model;

    public function items()
    {
        return [
            'view' => [
                'label' => Yii::t('hipanel', 'View'),
                'icon' => 'fa-info',
                'url' => ['@crontab/view', 'id' => $this->model->id],
            ],
        ];
    }
}
