<?php

namespace hipanel\modules\hosting\grid;

use hipanel\grid\MainColumn;
use hipanel\modules\server\grid\ServerColumn;
use Yii;
use yii\helpers\Html;

class BackupGridView extends \hipanel\grid\BoxedGridView
{
    static public function defaultColumns()
    {
        return [
            'id' => [
                'format' => 'html',
                'attribute' => 'id',
                'value' => function($model) {
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
                'value' => function($model) {
                    $labelType = $model->object === 'db' ?
                        Html::tag('span', Yii::t('app', 'Data Base'), ['class' => 'label label-info']) :
                        Html::tag('span', Yii::t('app', 'Domain'), ['class' => 'label label-default']);
                    return $labelType
                    . '&nbsp;' .
                    Html::a($model->name, [sprintf('/hosting/%s/view', $model->object), 'id' => $model->object_id], ['data-pjax' => 0]);
                }
            ],
            'name' => [
                'format' => 'raw',
                'attribute' => 'name',
                'value' => function($model) {
                    return Html::a($model->name, [sprintf('/hosting/%s/view', $model->object), 'id' => $model->object_id], ['data-pjax' => 0]);
                }
            ],
            'size_gb' => [
                'attribute' => 'size_gb',
                'value' => function($model) {
                    return sprintf('%s GB', $model->size_gb);
                }
            ],
        ];
    }
}
