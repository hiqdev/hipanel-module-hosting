<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\grid;

use hipanel\grid\ActionColumn;
use hipanel\grid\MainColumn;
use hipanel\modules\server\grid\ServerColumn;
use Yii;

class RequestGridView extends \hipanel\grid\BoxedGridView
{
    static public function defaultColumns()
    {
        return [
            'action' => [
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
                'sortAttribute' => 'account',
                'attribute' => 'account_id',
                'class' => AccountColumn::className()
            ],

            'time' => [
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->time);
                }
            ],
            'actions' => [
                'class' => ActionColumn::className(),
                'template' => '{view} {delete}',
            ],
        ];
    }
}
