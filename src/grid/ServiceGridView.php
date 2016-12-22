<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\grid;

use hipanel\grid\MainColumn;
use hipanel\grid\RefColumn;
use hipanel\helpers\FontIcon;
use hipanel\modules\hosting\menus\ServiceActionsMenu;
use hipanel\modules\hosting\models\DbSearch;
use hipanel\modules\hosting\models\HdomainSearch;
use hipanel\modules\hosting\models\Soft;
use hipanel\modules\server\grid\ServerColumn;
use hipanel\widgets\ArraySpoiler;
use hipanel\widgets\State;
use hiqdev\yii2\menus\grid\MenuColumn;
use Yii;
use yii\helpers\Html;

class ServiceGridView extends \hipanel\grid\BoxedGridView
{
    public static function defaultColumns()
    {
        return [
            'service' => [
                'class' => MainColumn::class,
                'attribute' => 'name',
                'filterAttribute' => 'service_like',
            ],
            'server' => [
                'class' => ServerColumn::class,
            ],
            'object' => [
                'format' => 'raw',
                'header' => Yii::t('hipanel:hosting', 'Object'),
                'value' => function ($model) {
                    $html = $model->name . ' ';

                    if ($model->soft_type === Soft::TYPE_WEB) {
                        $url['ok'] = ['@hdomain', (new HdomainSearch())->formName() => ['server' => $model->server, 'service' => $model->name]];
                        $url['deleted'] = ['@hdomain', (new HdomainSearch())->formName() => ['server' => $model->server, 'service' => $model->name, 'state' => 'deleted']];
                        $type = function ($count) {
                            return Yii::t('hipanel:hosting', '{0, plural, one{domain} other{domains}}', (int) $count);
                        };
                    } elseif ($model->soft_type === Soft::TYPE_DB) {
                        $url['ok'] = ['@db', (new DbSearch())->formName() => ['server' => $model->server, 'service' => $model->name]];
                        $url['deleted'] = ['@db', (new DbSearch())->formName() => ['server' => $model->server, 'service' => $model->name, 'state' => 'deleted']];
                        $type = function ($count) {
                            return Yii::t('hipanel:hosting', '{0, plural, one{# DB} other{# DBs}}', (int) $count);
                        };
                    } else {
                        return $html;
                    }

                    if ($count = $model->objects_count['ok']) {
                        $html .= Html::a(
                            (int) $count . '&nbsp;' . FontIcon::i('fa-check') . ' ' . $type($count),
                            $url['ok'],
                            ['class' => 'btn btn-success btn-xs']
                        );
                    }
                    $html .= ' ';
                    if (($count = $model->objects_count['deleted']) > 0) {
                        $html .= Html::a(
                            (int) $count . '&nbsp;' . FontIcon::i('fa-trash') . ' ' . $type($count),
                            $url['deleted'],
                            ['class' => 'btn btn-xs btn-warning']
                        );
                    }

                    return $html;
                },
            ],
            'ip' => [
                'format' => 'raw',
                'label' => Yii::t('hipanel:hosting', 'IP'),
                'value' => function ($model) {
                    return ArraySpoiler::widget(['data' => array_unique(array_merge((array) $model->ip, (array) $model->ips))]);
                },
            ],
            'bin' => [
                'format' => 'html',
                'value' => function ($model) {
                    return $model->bin ? Html::tag('code', $model->bin) : '';
                },
            ],
            'etc' => [
                'format' => 'html',
                'value' => function ($model) {
                    return $model->etc ? Html::tag('code', $model->etc) : '';
                },
            ],
            'soft' => [
                'value' => function ($model) {
                    return $model->soft;
                },
            ],
            'state' => [
                'class' => RefColumn::class,
                'i18nDictionary' => 'hipanel:hosting',
                'format' => 'raw',
                'value' => function ($model) {
                    return State::widget(compact('model'));
                },
                'gtype' => 'state,service',
            ],
            'actions' => [
                'class' => MenuColumn::class,
                'menuClass' => ServiceActionsMenu::class,
            ],
        ];
    }
}
