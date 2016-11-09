<?php

/*
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\grid;

use hipanel\grid\ActionColumn;
use hipanel\grid\RefColumn;
use hipanel\modules\server\grid\ServerColumn;
use Yii;
use yii\helpers\Html;

class RequestGridView extends \hipanel\grid\BoxedGridView
{
    public static function defaultColumns()
    {
        return [
            'classes' => [
                'label' => Yii::t('hipanel/hosting', 'Action'),
                'filter' => false,
                'enableSorting' => false,
                'value' => function ($model) {
                    return sprintf('%s, %s', $model->object_class, $model->action);
                },
            ],
            'server' => [
                'sortAttribute' => 'server',
                'attribute' => 'server_id',
                'class' => ServerColumn::class,
            ],
            'account' => [
                'enableSorting' => false,
                'class' => AccountColumn::class
            ],
            'object' => [
                'enableSorting' => false,
                'filter' => false,
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('<i class="fa fa-external-link"></i>&nbsp;' . $model->object_name,
                        ['/hosting/' . $model->object_class . '/view', 'id' => $model->object_id],
                        ['data-pjax' => 0]
                    );
                }

            ],
            'time' => [
                'filter' => false,
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->time);
                }
            ],
            'state' => [
                'class' => RefColumn::class,
                'i18nDictionary' => 'hipanel/hosting',
                'gtype' => 'state,request',
                'format' => 'raw',
                'value' => function ($model) {
                    $colors = [
                        'error' => 'danger',
                        'progress' => 'info',
                        'done' => 'success',
                    ];

                    return Html::tag('span', Yii::t('hipanel/hosting', $model->state_label), [
                        'class' => 'text-' . (isset($colors[$model->state]) ? $colors[$model->state] : 'default')
                    ]);
                }
            ],
            'actions' => [
                'class' => ActionColumn::class,
                'template' => '{view} {delete}',
            ],
        ];
    }
}
