<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\grid;

use hipanel\grid\ActionColumn;
use hipanel\grid\MainColumn;
use hipanel\modules\hosting\models\DbSearch;
use hipanel\modules\hosting\models\HdomainSearch;
use hipanel\modules\hosting\models\Service;
use hipanel\modules\hosting\models\Soft;
use hipanel\modules\server\grid\ServerColumn;
use hipanel\widgets\ArraySpoiler;
use kartik\helpers\Html;
use Yii;
use yii\base\InvalidParamException;
use yii\bootstrap\Button;

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
                        if ($model->soft_type === Soft::TYPE_DB) {
                            $html .= Html::a(
                                Yii::t('hipanel/hosting', '{0, plural, one{# DB} other{# DBs}}', $model->objects_count),
                                ['@db', (new DbSearch)->formName() => ['server' => $model->server, 'service' => $model->name]],
                                ['class' => 'btn btn-default btn-xs']
                            );
                        } elseif ($model->soft_type === Soft::TYPE_WEB) {
                            $html .= Html::a(
                                Yii::t('hipanel/hosting', '{0, plural, one{# domain} other{# domains}}', $model->objects_count),
                                ['@hdomain', (new HdomainSearch)->formName() => ['server' => $model->server, 'service' => $model->name]],
                                ['class' => 'btn btn-default btn-xs']
                            );
                        } else {
                            throw new InvalidParamException('The object type is not supported', $model);
                        }
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
