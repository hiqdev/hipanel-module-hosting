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
use hipanel\widgets\ArraySpoiler;
use Yii;
use yii\filters\auth\HttpBasicAuth;
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
            'hdomain_with_aliases' => [
                'format' => 'raw',
                'attribute' => 'domain',
                'filterAttribute' => 'domain_like',
                'value' => function ($model) {
                    $aliases = (array)$model->getAttribute('aliases');

                    $html = Html::a($model->domain, ['view', 'id' => $model->id], ['class' => 'bold']) . '&nbsp;';
                    $html .= ArraySpoiler::widget([
                        'data' => $aliases,
                        'visibleCount' => 0,
                        'delimiter' => '<br />',
                        'button' => [
                            'label' => Yii::t('app', '+{0, plural, one{# alias} other{# aliases}}', count($aliases)),
                            'popoverOptions' => ['html' => true],
                        ],
                        'formatter' => function ($value, $key) {
                            return Html::a($value, ['view', 'id' => $key]);
                        },
                    ]);

                    return $html;
                }
            ],
            'account' => [
                'class' => AccountColumn::className()
            ],
            'server' => [
                'class' => ServerColumn::className()
            ],
            'ip' => [
                'enableSorting' => false,
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
                'label' => Yii::t('app', 'Service'),
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
            'dns_on' => [
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->dns_on ? Yii::t('app', 'Enabled') : Yii::t('app', 'Disabled');
                }
            ],
            'aliases' => [
                'label' => Yii::t('app', 'Aliases'),
                'format' => 'raw',
                'value' => function ($model) {
                    return ArraySpoiler::widget([
                        'data' => (array)$model->getAttribute('aliases'),
                        'delimiter' => '<br />',
                        'button' => ['popoverOptions' => ['html' => true]],
                    ]);
                }
            ],
            'actions' => [
                'class' => ActionColumn::className(),
                'template' => '{view} {delete}'
            ],
        ];
    }
}
