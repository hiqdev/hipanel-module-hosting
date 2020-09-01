<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\grid;

use hipanel\modules\hosting\menus\PrefixActionsMenu;
use hipanel\modules\hosting\models\Address;
use hiqdev\yii2\menus\grid\MenuColumn;
use yii\helpers\Html;

class AddressGridView extends PrefixGridView
{
    public function columns()
    {
        return array_merge(parent::columns(), [
            'ip' => [
                'format' => 'html',
                'value' => static function (Address $address) {
                    return Html::a($address->ip, ['@address/view', 'id' => $address->id], ['class' => 'text-bold']);
                },
            ],
            'actions' => [
                'class' => MenuColumn::class,
                'contentOptions' => ['style' => 'width: 1%; white-space:nowrap;'],
                'menuClass' => PrefixActionsMenu::class,
            ],
        ]);
    }
}
