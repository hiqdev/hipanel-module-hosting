<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\grid;

use hipanel\grid\ActionColumn;
use hipanel\grid\MainColumn;
use hipanel\grid\RefColumn;
use hipanel\helpers\Url;
use hipanel\modules\hosting\models\Hdomain;
use hipanel\modules\hosting\widgets\backup\BackupGridRow;
use hipanel\modules\hosting\widgets\hdomain\State;
use hipanel\modules\server\grid\ServerColumn;
use hipanel\widgets\ArraySpoiler;
use hipanel\widgets\Label;
use hipanel\widgets\XEditable;
use Yii;
use yii\helpers\Html;

class HdomainGridView extends \hipanel\grid\BoxedGridView
{
    public function columns()
    {
        return array_merge(parent::columns(), [
            'hdomain' => [
                'class' => MainColumn::class,
                'filterAttribute' => 'domain_like',
                'attribute' => 'domain',
            ],
            'hdomain_with_aliases' => [
                'format' => 'raw',
                'attribute' => 'domain',
                'filterAttribute' => 'domain_like',
                'value' => function ($model) {
                    $aliases = (array) $model->getAttribute('aliases');

                    $html = Html::a(Html::encode($model->domain), ['view', 'id' => Html::encode($model->id)], ['class' => 'bold']) . '&nbsp;';
                    $html .= ArraySpoiler::widget([
                        'data' => $aliases,
                        'visibleCount' => 0,
                        'delimiter' => '<br />',
                        'button' => [
                            'label' => Yii::t('hipanel', '+{0, plural, one{# alias} other{# aliases}}', count($aliases)),
                            'class' => 'badge progress-bar-info',
                            'popoverOptions' => ['html' => true],
                        ],
                        'formatter' => function ($value, $key) {
                            return Html::a($value, ['view', 'id' => $key]);
                        },
                    ]);

                    return $html;
                },
            ],
            'account' => [
                'format' => 'html',
                'value' => function (Hdomain $hdomain): string {
                    return Html::a($hdomain->account, ['@account/view', 'id' => $hdomain->account_id]);
                }
            ],
            'server' => [
                'class' => ServerColumn::class,
            ],
            'ip' => [
                'enableSorting' => false,
                'filter' => false,
                'format' => 'html',
                'value' => function ($model) {
                    $vhost = $model->getAttribute('vhost');

                    $html = $vhost['ip'];
                    if (isset($vhost['port']) && $vhost['port'] !== 80) {
                        $html .= ':' . $vhost['port'];
                    }
                    if ($model->isProxied) {
                        $backend = $vhost['backend'];
                        $html .= ' ' . Html::tag('i', '', ['class' => 'fa fa-long-arrow-right']) . ' ' . $backend['ip'];
                        if ($backend['port'] !== 80) {
                            $html .= ':' . $backend['port'];
                        }
                    }

                    return $html;
                },
            ],
            'service' => [
                'label' => Yii::t('hipanel', 'Service'),
                'value' => function ($model) {
                    return $model->getAttribute('vhost')['service'];
                },
            ],
            'state' => [
                'class' => RefColumn::class,
                'i18nDictionary' => 'hipanel:hosting',
                'format' => 'raw',
                'value' => function ($model) {
                    $html = '';
                    if ($model->dns_on && empty($model->dns_hdomain_id)) {
                        $html .= Label::widget([
                            'color' => 'success',
                            'label' => Yii::t('hipanel', 'DNS'),
                            'tag' => 'span',
                            'labelOptions' => ['title' => Yii::t('hipanel:hosting', 'DNS is enabled')],
                        ]);
                    }
                    $html .= ' ' . State::widget(compact('model'));

                    return $html;
                },
                'gtype' => 'state,hdomain',
            ],
            'dns_on' => [
                'value' => function ($model) {
                    return $model->dns_on ? Yii::t('hipanel', 'Enabled') : Yii::t('hipanel', 'Disabled');
                },
            ],
            'dns_switch' => [
                'attribute' => 'dns_on',
                'label' => Yii::t('hipanel:hosting', 'DNS'),
                'format' => 'raw',
                'value' => function ($model) {
                    if (empty($model->dns_hdomain_id)) {
                        return XEditable::widget([
                            'model' => $model,
                            'attribute' => 'dns_on',
                            'pluginOptions' => [
                                'type' => 'select',
                                'title' => Yii::t('hipanel:hosting', 'Toggles DNS records upload on NS server'),
                                'source' => ['' => Yii::t('hipanel', 'Disabled'), '1' => Yii::t('hipanel', 'Enabled')],
                                'url' => Url::to('set-dns-on'),
                                'placement' => 'bottom',
                            ],
                            'linkOptions' => [
                                'style' => ['word-break' => 'break-all'],
                            ],
                        ]);
                    } else {
                        return Yii::t('hipanel:hosting', 'Belongs to {link}', [
                            'link' => Html::a($model->dns_hdomain_domain, Url::to(['@hdomain/view', 'id' => $model->dns_hdomain_id])),
                        ]);
                    }
                },
            ],
            'aliases' => [
                'label' => Yii::t('hipanel', 'Aliases'),
                'format' => 'raw',
                'value' => function ($model) {
                    return ArraySpoiler::widget([
                        'data' => (array) $model->getAttribute('aliases'),
                        'delimiter' => '<br />',
                        'button' => ['popoverOptions' => ['html' => true]],
                    ]);
                },
            ],
            'backups_widget' => [
                'label' => Yii::t('hipanel:hosting', 'Backups'),
                'format' => 'html',
                'value' => function ($model) {
                    return BackupGridRow::widget(['model' => $model]);
                },
            ],
            'actions' => [
                'class' => ActionColumn::class,
                'template' => '{view} {delete}',
            ],
        ]);
    }
}
