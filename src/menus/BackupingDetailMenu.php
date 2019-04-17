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
