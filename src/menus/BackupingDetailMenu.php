<?php

namespace hipanel\modules\hosting\menus;

use Yii;

class BackupingDetailMenu extends \hipanel\menus\AbstractDetailMenu
{
    public $model;

    public function items()
    {
        return [
            [
                'label' => Yii::t('hipanel:hosting', 'Update settings'),
                'icon' => 'fa-pencil',
                'url' => ['@backuping/update', 'id' => $this->model->id],
                'encode' => false,
                'visible' => Yii::$app->user->can('support'),
            ],
        ];
    }
}
