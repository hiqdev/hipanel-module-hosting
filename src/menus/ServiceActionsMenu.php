<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\menus;

use Yii;

class ServiceActionsMenu extends \hiqdev\yii2\menus\Menu
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
