<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\grid;

use hipanel\grid\ActionColumn;
use hipanel\grid\RefColumn;
use hipanel\modules\server\grid\ServerColumn;
use Yii;
use yii\helpers\Html;

class RequestGridView extends \hipanel\grid\BoxedGridView
{
    static public function defaultColumns()
    {
        return [
            'classes' => [
                'value' => function ($model) {
                    return sprintf('%s, %s', $model->type, $model->action);
                },
                'filter' => false,
                'enableSorting' => false,
            ],
            'server' => [
                'sortAttribute' => 'server',
                'attribute' => 'server_id',
                'class' => ServerColumn::className(),
            ],
            'account' => [
                'enableSorting' => false,
                'attribute' => 'account_id',
                'class' => AccountColumn::className()
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
                'class' => RefColumn::className(),
                'gtype' => 'state,request',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->state_label;
                }
            ],
            'actions' => [
                'class' => ActionColumn::className(),
                'template' => '{view} {delete}',
            ],
        ];
    }
}
