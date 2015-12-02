<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\grid;

use hipanel\grid\ActionColumn;
use hipanel\grid\MainColumn;
use hipanel\helpers\FontIcon;
use hipanel\modules\hosting\models\HdomainSearch;
use hipanel\modules\hosting\widgets\ip\IpTag;
use hipanel\widgets\ArraySpoiler;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Html;

class IpGridView extends \hipanel\grid\BoxedGridView
{
    static public $ipTags = [];

    static public function setIpTags($ipTags)
    {
        static::$ipTags = $ipTags;
    }

    static public function defaultColumns()
    {
        return [
            'ip' => [
                'class' => MainColumn::className(),
                'filterAttribute' => 'ip_like',
            ],
            'tags' => [
                'format' => 'raw',
                'attribute' => 'tag',
                'filter' => function ($column, $model, $attribute) {
                    return Html::activeDropDownList($model, 'tag_in', array_merge(['' => Yii::t('app', '---')], static::$ipTags), ['class' => 'form-control']);
                },
                'value' => function ($model) {
                    $labels = [];
                    foreach ($model->tags as $tag) {
                        $labels[] = IpTag::widget(['tag' => $tag]);
                    }
                    return implode(' ', $labels);
                }
            ],
            'counters' => [
                'format' => 'html',
                'value' => function ($model) {
                    $html = '';
                    foreach ($model->objects_count as $count) {
                        if ($count['type'] === 'hdomain') {
                            $url['ok'] = ['@hdomain', (new HdomainSearch)->formName() => ['ip_like' => $model->ip]];
                            $url['deleted'] = ['@hdomain', (new HdomainSearch)->formName() => ['ip_like' => $model->ip, 'state' => 'deleted']];
                        } else {
                            throw new InvalidParamException('The object type is not supported', $model);
                        }

                        if ($count['ok']) {
                            $html .= Html::a(
                                (int)$count['ok'] . '&nbsp;' . FontIcon::i('fa-check'),
                                $url['ok'],
                                ['class' => 'btn btn-success btn-xs']
                            );
                        }
                        $html .= ' ';
                        if ($count['deleted'] > 0) {
                            $html .= Html::a(
                                (int)$count['deleted'] . '&nbsp;' . FontIcon::i('fa-trash'),
                                $url['deleted'],
                                ['class' => 'btn btn-xs btn-warning']
                            );
                        }
                    }

                    return $html;
                }
            ],
            'links' => [
                'format' => 'html',
                'value' => function ($model) {
                    $items = [];
                    foreach ($model->links as $link) {
                        $item = Html::a($link->device, ['@server/view', 'id' => $link->device_id]);
                        if ($link->service_id) {
                            $item .= '&nbsp;' . FontIcon::i('fa-long-arrow-right');
                            $item .= '&nbsp;' . Html::a($link->service ?: $link->soft, ['@service/update', 'id' => $link->service_id]);
                            $items[] = $item;
                        }
                    }
                    return ArraySpoiler::widget(['data' => $items, 'visibleCount' => 3]);
                }
            ],
            'actions' => [
                'class' => ActionColumn::className(),
                'template' => '{view} {expand} {update} {delete}',
                'buttons' => [
                    'expand' => function ($url, $model, $key) {
                        $options = array_merge([
                            'title' => Yii::t('hipanel/hosting', 'Expand'),
                            'aria-label' => Yii::t('hipanel/hosting', 'Expand'),
                            'data-pjax' => '0',
                        ]);

                        return Html::a(FontIcon::i('fa-th') . Yii::t('hipanel/hosting', 'Expand'), $url, $options);
                    }
                ]
            ],

        ];
    }
}