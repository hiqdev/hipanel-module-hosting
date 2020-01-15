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
                'visible' => Yii::$app->user->can('support') && !$this->model->isDeleted(),
            ],[
                'label' => Yii::t('hipanel', 'Enable'),
                'icon' => 'fa-activate',
                'url' => ['@backuping/enable', 'id' => $this->model->id],
                'encode' => false,
                'visible' => $this->model->canBeEnabled(),
                'linkOptions' => [
                    'data' => [
                        'method' => 'post',
                        'pjax' => '0',
                        'params' => [
                            'Backuping[id]' => $this->model->id,
                        ],
                    ],
                ],
            ], [
                'label' => Yii::t('hipanel', 'Restore'),
                'icon' => 'fa-archive',
                'url' => ['@backuping/undelete', 'id' => $this->model->id],
                'encode' => false,
                'visible' => $this->model->canBeRestored(),
                'linkOptions' => [
                    'data' => [
                        'method' => 'post',
                        'pjax' => '0',
                        'params' => [
                            'Backuping[id]' => $this->model->id,
                        ],
                    ],
                ],
            ], [
                'label' => Yii::t('hipanel', 'Disable'),
                'icon' => 'fa-ban',
                'url' => ['@backuping/disable', 'id' => $this->model->id],
                'encode' => false,
                'visible' => $this->model->canBeDisabled(),
                'linkOptions' => [
                    'data' => [
                        'method' => 'post',
                        'pjax' => '0',
                        'params' => [
                            'Backuping[id]' => $this->model->id,
                        ],
                    ],
                ],
            ], [
                'label' => Yii::t('hipanel', 'Delete'),
                'icon' => 'fa-trash',
                'url' => ['@backuping/delete', 'id' => $this->model->id],
                'encode' => false,
                'visible' => $this->model->canBeDeleted(),
                'linkOptions' => [
                    'data' => [
                        'confirm' => Yii::t('hipanel:hosting', 'Are you sure you want to delete backuping'),
                        'method' => 'post',
                        'pjax' => '0',
                        'params' => [
                            'Backuping[id]' => $this->model->id,
                        ],
                    ],
                ],

            ],
        ];
    }
}
