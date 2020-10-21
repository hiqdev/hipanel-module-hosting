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
use hipanel\grid\RefColumn;
use hipanel\grid\XEditableColumn;
use hipanel\modules\hosting\menus\PrefixActionsMenu;
use hipanel\modules\hosting\models\AddressSearch;
use hipanel\modules\hosting\models\Prefix;
use hiqdev\yii2\menus\grid\MenuColumn;
use Yii;
use yii\helpers\Html;

class PrefixGridView extends BoxedGridView
{
    public function columns()
    {
        return array_merge(parent::columns(), [
            'ip' => [
                'format' => 'html',
                'value' => static function (Prefix $prefix) {
                    if ($prefix->isSuggested()) {
                        return Html::a($prefix->ip, ['@prefix/create', 'ip' => $prefix->ip], ['class' => 'text-bold']);
                    }

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
                'value' => static fn($model) => $model->site ?? $model->parent->site,
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
                    'url' => '@prefix/set-note',
                ],
                'filter' => true,
                'popover' => Yii::t('hipanel', 'Make any notes for your convenience'),
            ],
            'text_note' => [
                'attribute' => 'note',
            ],
            'aggregate' => [
                'attribute' => 'aggregate',
                'format' => 'html',
                'value' => static function ($prefix): string {
                    return $prefix->aggregate ?
                        Html::a($prefix->aggregate, ['@aggregate/view', 'id' => $prefix->aggregate_id]) :
                        '';
                },
            ],
            'ip_count' => [
                'attribute' => 'ip_count',
                'label' => Yii::t('hipanel.hosting.ipam', 'IP Addresses'),
                'format' => 'html',
                'value' => static function ($prefix): string {
                    return $prefix->ip_count > 0 ?
                        Html::a('IP Addresses (' . $prefix->ip_count . ')', [
                            '@address/index', (new AddressSearch)->formName() => ['ip_cnts' => $prefix->ip],
                        ], ['class' => 'btn btn-success btn-flat btn-sm']) :
                        $prefix->ip_count;
                },
            ],
            'tags' => [
                'class' => TagsColumn::class,
            ],
            'actions' => [
                'class' => MenuColumn::class,
                'contentOptions' => ['style' => 'width: 1%; white-space:nowrap;'],
                'menuClass' => PrefixActionsMenu::class,
            ],
        ]);
    }
}
