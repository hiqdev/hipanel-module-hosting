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

use hiqdev\menumanager\Menu;
use Yii;

class AccountDetailMenu extends Menu
{
    public $model;

    public $blockReasons = [];

    public function items()
    {
        return [
            [
                'label' => $this->renderView('_change-password', ['model' => $this->model]),
                'encode' => false,
            ],
            [
                'label' => $this->renderView('_manage-ip-restrictions', ['model' => $this->model]),
                'encode' => false,
            ],
            [
                'label' => $this->renderView('_mail-settings', ['model' => $this->model]),
                'encode' => false,
                'visible' => $this->model->canSetMailSettings(),
            ],
            [
                'label' => $this->renderView('_block', ['model' => $this->model, 'blockReasons' => $this->blockReasons]),
                'encode' => false,
                'visible' => Yii::$app->user->can('support') && Yii::$app->user->id !== $this->model->client_id,
            ],
            [
                'label' => $this->renderView('_delete', ['model' => $this->model]),
                'encode' => false,
            ],
        ];
    }

    public function getViewPath()
    {
        return '@vendor/hiqdev/hipanel-module-hosting/src/views/account';
    }
}
