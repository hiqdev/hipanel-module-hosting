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

use hipanel\menus\AbstractDetailMenu;
use hipanel\modules\hosting\models\Prefix;
use Yii;

class AddressActionsMenu extends AbstractDetailMenu
{
    public Prefix $model;

    public function items(): array
    {
        return [
            'view' => [
                'label' => Yii::t('hipanel', 'View'),
                'icon' => 'fa-eye',
                'url' => ['@address/view', 'id' => $this->model->id],
            ],
            'update' => [
                'label' => Yii::t('hipanel', 'Update'),
                'icon' => 'fa-pencil',
                'url' => ['@address/update', 'id' => $this->model->id],
            ],
        ];
    }
}
