<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\grid;

use hipanel\grid\ActionColumn;
use hipanel\grid\MainColumn;
use hipanel\grid\RefColumn;
use hipanel\modules\hosting\widgets\hdomain\State;
use hipanel\modules\server\grid\ServerColumn;
use yii\helpers\Html;

class HdomainGridView extends \hipanel\grid\BoxedGridView
{
    static public function defaultColumns()
    {
        return [
            'hdomain' => [
                'class' => MainColumn::className(),
                'filterAttribute' => 'domain_like',
                'attribute' => 'domain'
            ],
            'account' => [
                'class' => AccountColumn::className()
            ],
            'server' => [
                'class' => ServerColumn::className()
            ],
            'ip' => [
                'filter' => false,
                'format' => 'raw',
                'value' => function ($model) {
                    $html = '';
                    $vhost = $model->getAttribute('vhost');

                    $html = $vhost['ip'];
                    if (isset($vhost['port']) && $vhost['port'] != 80) {
                        $html .= ':' . $vhost['port'];
                    }
                    if ($model->isProxied) {
                        $backend = $vhost['backend'];
                        $html .= ' ' . Html::tag('i', '', ['class' => 'fa fa-long-arrow-right']) . ' ' . $backend['ip'];
                        if ($backend['port'] != 80) {
                            $html .= ':' . $backend['port'];
                        }
                    }
                    return $html;
                }
            ],
            'service' => [
                'value' => function ($model) {
                    return $model->getAttribute('vhost')['service'];
                }
            ],
            'state' => [
                'class' => RefColumn::className(),
                'format' => 'raw',
                'value' => function ($model) {
                    return State::widget(compact('model'));
                },
                'gtype' => 'state,hdomain',
            ],
            'actions' => [
                'class' => ActionColumn::className(),
                'template' => '{view} {delete}'
            ],
        ];
    }
}
