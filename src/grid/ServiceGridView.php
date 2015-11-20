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
use hipanel\widgets\ArraySpoiler;
use kartik\helpers\Html;

class ServiceGridView extends \hipanel\grid\BoxedGridView
{
    static public function defaultColumns()
    {
        return [
            'service' => [
                'class'                 => MainColumn::className(),
                'attribute'             => 'name',
                'filterAttribute'       => 'service_like',
            ],
            'server_id' => [
                'class' => ServerColumn::className(),
            ],
            'object' => [
                'format' => 'raw',
                'value' => function ($model) {

                },
            ],
            'ip' => [
                'format' => 'raw',
                'value' => function ($model) {
                    return ArraySpoiler::widget(['data' => $model->ips]);
                },
            ],
            'bin' => [
                'format' => 'html',
                'value' => function ($model) {
                    return $model->bin ? Html::tag('code', $model->bin) : '';
                }
            ],
            'etc' => [
                'format' => 'html',
                'value' => function ($model) {
                    return $model->etc ? Html::tag('code', $model->etc) : '';
                }
            ],
            'soft' => [
                'value' => function ($model) {
                    return $model->soft;
                }
            ],
            'state' => [
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
