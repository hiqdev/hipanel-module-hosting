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

use hipanel\grid\BoxedGridView;
use hipanel\grid\DataColumn;
use hipanel\grid\RefColumn;
use hipanel\grid\XEditableColumn;
use hipanel\modules\hosting\menus\PrefixActionsMenu;
use hipanel\modules\hosting\models\Prefix;
use hiqdev\yii2\menus\grid\MenuColumn;
use Yii;
use yii\helpers\Html;
use yii\helpers\IpHelper;

class PrefixGridView extends BoxedGridView
{
    public function columns()
    {
        return array_merge(parent::columns(), [
            'ip' => [
                'format' => 'html',
                'value' => static function (Prefix $prefix) {
                    return Html::a($prefix->ip, ['@prefix/view', 'id' => $prefix->id], ['class' => 'text-bold']);
                },
            ],
            'type' => [
                'class' => RefColumn::class,
                'i18nDictionary' => 'hipanel.hosting.ipam',
                'format' => 'raw',
                'gtype' => 'type,ip_prefix',
            ],
            'vrf' => [
                'class' => RefColumn::class,
                'i18nDictionary' => 'hipanel.hosting.ipam',
                'format' => 'raw',
                'gtype' => 'type,ip_vrf',
            ],
            'role' => [
                'class' => RefColumn::class,
                'i18nDictionary' => 'hipanel.hosting.ipam',
                'format' => 'raw',
                'gtype' => 'type,ip_prefix_role',
            ],
            'site' => [
                'class' => RefColumn::class,
                'i18nDictionary' => 'hipanel.hosting.ipam',
                'format' => 'raw',
                'gtype' => 'type,location',
            ],
            'family' => [
                'class' => FamilyColumn::class,
            ],
            'utilization' => [
                'class' => UtilizationColumn::class,
            ],
            'note' => [
                'class' => XEditableColumn::class,
                'pluginOptions' => [
                    'url' => 'set-note',
                ],
                'filter' => true,
                'popover' => Yii::t('hipanel', 'Make any notes for your convenience'),
            ],
            'actions' => [
                'class' => MenuColumn::class,
                'contentOptions' => ['style' => 'width: 1%; white-space:nowrap;'],
                'menuClass' => PrefixActionsMenu::class,
            ],
        ]);
    }
}
