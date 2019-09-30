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

use hipanel\grid\RefColumn;
use hipanel\modules\hosting\menus\RequestActionsMenu;
use hipanel\modules\hosting\models\Request;
use hipanel\modules\server\grid\ServerColumn;
use hipanel\widgets\gridLegend\ColorizeGrid;
use hiqdev\yii2\menus\grid\MenuColumn;
use Yii;
use yii\helpers\Html;
use yii\helpers\UnsetArrayValue;

class RequestGridView extends \hipanel\grid\BoxedGridView
{
    use ColorizeGrid;

    public function columns()
    {
        return array_merge(parent::columns(), [
            'classes' => [
                'label' => Yii::t('hipanel:hosting', 'Action'),
                'filter' => false,
                'enableSorting' => false,
                'value' => function ($model) {
                    return sprintf('%s, %s', $model->object_class, $model->action);
                },
            ],
            'server' => class_exists(ServerColumn::class) ? [
                'sortAttribute' => 'server',
                'attribute' => 'server_id',
                'class' => ServerColumn::class,
            ] : [
                'visible' => false,
            ],
            'account' => [
                'enableSorting' => false,
                'class' => AccountColumn::class,
            ],
            'object' => [
                'enableSorting' => false,
                'filter' => false,
                'format' => 'raw',
                'value' => function (Request $model): string {
                    return Html::a('<i class="fa fa-external-link"></i>&nbsp;' . $model->object,
                        ['/hosting/' . $model->object_class . '/view', 'id' => $model->object_id],
                        ['data-pjax' => 0]
                    );
                },
            ],
            'time' => [
                'filter' => false,
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->time);
                },
            ],
            'state' => [
                'class' => RefColumn::class,
                'i18nDictionary' => 'hipanel:hosting',
                'gtype' => 'state,request',
                'format' => 'raw',
                'value' => function ($model) {
                    $colors = [
                        'error' => 'danger',
                        'progress' => 'info',
                        'done' => 'success',
                    ];

                    return Html::tag('span', Yii::t('hipanel:hosting', $model->state_label), [
                        'class' => 'text-' . (isset($colors[$model->state]) ? $colors[$model->state] : 'default'),
                    ]);
                },
                'filterOverrides' => [
                    'done' => new UnsetArrayValue(),
                ],
            ],
            'parent' => [
                'format' => 'raw',
                'value' => function (Request $model): string {
                    return Html::a($model->parent, ['@request/view', 'id' => $model->parent_id]);
                },
            ],
            'actions' => [
                'class' => MenuColumn::class,
                'menuClass' => RequestActionsMenu::class,
            ],
        ]);
    }
}
