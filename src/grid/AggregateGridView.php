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
use hipanel\grid\MainColumn;
use hipanel\grid\RefColumn;
use hipanel\grid\XEditableColumn;
use hipanel\modules\hosting\menus\AggregateActionsMenu;
use hiqdev\yii2\menus\grid\MenuColumn;
use Yii;

class AggregateGridView extends BoxedGridView
{
    public function columns()
    {
        return array_merge(parent::columns(), [
            'ip' => [
                'class' => MainColumn::class,
                'format' => 'html',
                'attribute' => 'ip',
                'filterAttribute' => 'ip_like',
            ],
            'state' => [
                'class' => RefColumn::class,
                'i18nDictionary' => 'hipanel.hosting.ipam',
                'format' => 'raw',
                'gtype' => 'state,ip',
            ],
            'type' => [
                'class' => RefColumn::class,
                'i18nDictionary' => 'hipanel.hosting.ipam',
                'format' => 'raw',
                'gtype' => 'type,ip',
            ],
            'rir' => [
                'class' => RefColumn::class,
                'i18nDictionary' => 'hipanel.hosting.ipam',
                'format' => 'raw',
                'gtype' => 'type,ip_rir',
            ],
            'note' => [
                'class' => XEditableColumn::class,
                'pluginOptions' => [
                    'url' => '@aggregate/set-note',
                ],
                'filter' => true,
                'popover' => Yii::t('hipanel', 'Make any notes for your convenience'),
            ],
            'utilization' => [
                'class' => UtilizationColumn::class,
            ],
            'family' => [
                'class' => FamilyColumn::class,
            ],
            'actions' => [
                'class' => MenuColumn::class,
                'contentOptions' => ['style' => 'width: 1%; white-space:nowrap;'],
                'menuClass' => AggregateActionsMenu::class,
            ],
        ]);
    }
}
