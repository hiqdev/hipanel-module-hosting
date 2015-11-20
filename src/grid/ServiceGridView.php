<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\grid;

use hipanel\grid\ActionColumn;
use hipanel\grid\MainColumn;
use hipanel\modules\hosting\models\Service;
use hipanel\modules\server\grid\ServerColumn;
use hipanel\widgets\ArraySpoiler;
use hipanel\widgets\Label;
use kartik\helpers\Html;
use Yii;

class ServiceGridView extends \hipanel\grid\BoxedGridView
{
    static public function defaultColumns()
    {
        return [
            'service' => [
                'class' => MainColumn::className(),
                'attribute' => 'name',
                'filterAttribute' => 'service_like',
            ],
            'server_id' => [
                'class' => ServerColumn::className(),
            ],
            'object' => [
                'format' => 'raw',
                'value' => function ($model) {
                    $html = $model->name;
                    if ($model->objects_count > 0) {
                        $html .= ' ';
                        if ($model->soft_type === Service::SOFT_TYPE_DB) {
                            $labelOptions = [
                                'label' => Yii::t('hipanel/hosting', '{0, plural, one{# DB} other{# DBs}}', $model->objects_count),
                                'color' => 'default',
                            ];
                        } elseif ($model->soft_type === Service::SOFT_TYPE_WEB) {
                            $labelOptions = [
                                'label' => Yii::t('hipanel/hosting', '{0, plural, one{# domain} other{# domains}}', $model->objects_count),
                                'color' => 'default',
                            ];
                        } else {
                            $labelOptions = [
                                'label' => Yii::t('hipanel/hosting', '{0}', $model->objects_count),
                                'color' => 'default'
                            ];
                        }

                        $html .= Label::widget($labelOptions); /// TODO create search url to search related
                    }

                    return $html;
                },
            ],
            'ip' => [
                'format' => 'raw',
                'label' => Yii::t('hipanel/hosting', 'IP'),
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
