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
use hipanel\grid\MainColumn;
use hipanel\modules\hosting\widgets\backup\ObjectLabelWidget;
use hipanel\modules\server\grid\ServerColumn;
use Yii;
use yii\helpers\Html;

class BackupGridView extends \hipanel\grid\BoxedGridView
{
    public static function defaultColumns()
    {
        return [
            'id' => [
                'format' => 'html',
                'attribute' => 'id',
                'value' => function ($model) {
                    return Html::tag('span', $model->id, ['class' => 'bold']);
                },
            ],
            'object_id' => [
                'class' => MainColumn::className(),
                'filterAttribute' => 'id',
                'attribute' => 'object_id'
            ],
            'backup' => [
                'class' => MainColumn::className(),
                'filterAttribute' => 'backup_like',
            ],
            'server' => [
                'class' => ServerColumn::className(),
            ],
            'account' => [
                'class' => AccountColumn::className()
            ],
            'object' => [
                'format' => 'raw',
                'attribute' => 'name',
                'filterAttribute' => 'name_like',
                'value' => function ($model) {
                    $labelType = ObjectLabelWidget::widget(compact('model'));
                    return $labelType . '&nbsp;' .
                        Html::a($model->name, ["@{$model->object}/view", 'id' => $model->object_id], ['data-pjax' => 0]);
                }
            ],
            'name' => [
                'format' => 'raw',
                'attribute' => 'name',
                'value' => function ($model) {
                    return Html::a($model->name, ["@{$model->object}/view", 'id' => $model->object_id], ['data-pjax' => 0]);
                }
            ],
            'size' => [
                'filter' => false,
                'value' => function ($model) {
                    return Yii::$app->formatter->asShortSize($model->size, 2);
                }
            ],
            'time' => [
                'filter' => false,
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->time);
                }
            ],
            'actions' => [
                'class' => ActionColumn::className(),
                'template' => '{view} {delete}',
            ],
            'inner_actions' => [
                'class' => ActionColumn::className(),
                'template' => '{deleteBackup}',
                'buttons' => [
                    'deleteBackup' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-trash-o"></i>&nbsp;' . Yii::t('hipanel', 'Delete'), ['/hosting/backup/delete', 'id' => $model->id], [
                            'aria-label'   => Yii::t('hipanel', 'Delete'),
                            'class' => 'btn btn-danger btn-xs',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method'  => 'POST',
                                'data-pjax' => '0',
                            ],
                        ]);
                    }
                ]
            ],
        ];
    }
}
