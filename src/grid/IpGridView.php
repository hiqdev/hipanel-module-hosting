<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\grid;

use hipanel\grid\MainColumn;
use hipanel\grid\XEditableColumn;
use hipanel\helpers\FontIcon;
use hipanel\helpers\Url;
use hipanel\modules\hosting\menus\IpActionsMenu;
use hipanel\modules\hosting\models\HdomainSearch;
use hipanel\modules\hosting\widgets\ip\IpTag;
use hipanel\widgets\ArraySpoiler;
use hipanel\widgets\XEditable;
use hiqdev\yii2\menus\grid\MenuColumn;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Html;

class IpGridView extends \hipanel\grid\BoxedGridView
{
    public $controllerUrl = '@ip';

    public $ipTags = [];

    public function columns()
    {
        return array_merge(parent::columns(), [
            'ip' => [
                'class' => MainColumn::class,
                'filterAttribute' => 'ip_like',
            ],
            'note' => [
                'class' => XEditableColumn::class,
                'pluginOptions' => [
                    'url'       => Url::to('set-note'),
                ],
                'widgetOptions' => [
                    'linkOptions' => [
                        'data-type' => 'textarea',
                    ],
                ],
                'visible' => Yii::$app->user->can('admin'),
            ],
            'tags' => [
                'format' => 'raw',
                'attribute' => 'tag',
                'header' => Yii::t('hipanel:hosting', 'Tags'),
                'visible' => Yii::$app->user->can('admin'),
                'filter' => function ($column, $model) {
                    return Html::activeDropDownList($model, 'tag_in', array_merge(['' => Yii::t('hipanel', '---')], $this->ipTags), ['class' => 'form-control']);
                },
                'value' => function ($model) {
                    $labels = [];
                    foreach ($model->tags as $tag) {
                        $labels[] = IpTag::widget(['tag' => $tag]);
                    }

                    return implode(' ', $labels);
                },
            ],
            'counters' => [
                'format' => 'html',
                'header' => Yii::t('hipanel:hosting', 'Counters'),
                'value' => function ($model) {
                    $html = '';
                    foreach ($model->objects_count as $count) {
                        if ($count['type'] === 'hdomain') {
                            $url['ok'] = ['@hdomain', (new HdomainSearch())->formName() => ['ip_like' => $model->ip]];
                            $url['deleted'] = ['@hdomain', (new HdomainSearch())->formName() => ['ip_like' => $model->ip, 'state' => 'deleted']];
                            $type = function ($count) {
                                return Yii::t('hipanel:hosting', '{0, plural, one{domain} other{domains}}', (int) $count);
                            };
                        } else {
                            throw new InvalidParamException('The object type is not supported', $model);
                        }

                        if ($count['ok']) {
                            $html .= Html::a(
                                (int) $count['ok'] . '&nbsp;' . FontIcon::i('fa-check') . ' ' . $type($count['ok']),
                                $url['ok'],
                                ['class' => 'btn btn-success btn-xs']
                            );
                        }
                        $html .= ' ';
                        if ($count['deleted'] > 0) {
                            $html .= Html::a(
                                (int) $count['deleted'] . '&nbsp;' . FontIcon::i('fa-trash') . ' ' . $type($count['deleted']),
                                $url['deleted'],
                                ['class' => 'btn btn-xs btn-warning']
                            );
                        }
                    }

                    return $html;
                },
            ],
            'links' => [
                'format' => 'html',
                'value' => function ($model) {
                    $items = [];
                    foreach ($model->links as $link) {
                        $item = Html::a($link->device, ['@server/view', 'id' => $link->device_id]);
                        if ($link->service_id) {
                            $item .= '&nbsp;' . FontIcon::i('fa-long-arrow-right');
                            $item .= '&nbsp;' . Html::a($link->service ?: $link->soft, ['@service/view', 'id' => $link->service_id]);
                        }
                        $items[] = $item;
                    }

                    return ArraySpoiler::widget(['data' => $items, 'visibleCount' => 3]);
                },
            ],
            'services' => [
                'attribute' => 'links',
                'format' => 'html',
                'label' => Yii::t('hipanel:server', 'Services'),
                'value' => function ($model) {
                    return ArraySpoiler::widget([
                        'data' => $model->links,
                        'formatter' => function ($link) {
                            if (Yii::$app->user->can('support') && Yii::getAlias('@service', false)) {
                                return Html::a($link->service, ['@service/view', 'id' => $link->service_id]);
                            }

                            return $link->service;
                        },
                    ]);
                },
            ],
            'actions' => [
                'class' => MenuColumn::class,
                'menuClass' => IpActionsMenu::class,
            ],
            'ptr' => [
                'options' => [
                    'style' => 'width: 40%',
                ],
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->canSetPtr()) {
                        return XEditable::widget([
                            'model' => $model,
                            'attribute' => 'ptr',
                            'pluginOptions' => [
                                'url' => Url::to('@ip/set-ptr'),
                            ],
                        ]);
                    }

                    return null;
                },
            ],
        ]);
    }
}
