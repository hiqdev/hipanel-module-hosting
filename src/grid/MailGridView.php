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
use hipanel\modules\hosting\widgets\mail\State;
use hipanel\modules\hosting\widgets\mail\Type;
use hipanel\modules\server\grid\ServerColumn;
use hipanel\widgets\ArraySpoiler;
use Yii;
use yii\helpers\Html;

class MailGridView extends \hipanel\grid\BoxedGridView
{
    static public function defaultColumns()
    {
        return [
            'mail' => [
                'class' => MainColumn::className(),
                'filterAttribute' => 'mail_like',
            ],
            'state' => [
                'class' => RefColumn::className(),
                'format' => 'raw',
                'value' => function ($model) {
                    return State::widget(compact('model'));
                },
                'gtype' => 'state,mail',
            ],
            'server' => [
                'class' => ServerColumn::className()
            ],
//            'sshftp_ips'    => [
//                'attribute'         => 'sshftp_ips',
//                'format'            => 'raw',
//                'value'             => function ($model) {
//                    return ArraySpoiler::widget([
//                        'data'         => $model->sshftp_ips,
//                        'visibleCount' => 3
//                    ]);
//                }
//            ],
            'type' => [
                'format' => 'raw',
                'filter' => function ($column, $model, $attribute) {
                    return Html::activeDropDownList($model, $attribute, [
                        '' => Yii::t('app', '---'),
                        'mailbox' => Yii::t('app', 'Mailbox'),
                        'forward_only' => Yii::t('app', 'Forward only'),
                        'mailbox_with_forwards' => Yii::t('app', 'Mailbox with forwards'),
                    ], [
                        'class' => 'form-control',
                    ]);
                },
                'value' => function ($model) {
                    return Type::widget(compact('model'));
                }
            ],
            'forwards' => [
                'format' => 'raw',
                'value' => function ($model) {
                    return ArraySpoiler::widget([
                        'delimiter' => '<br>',
                        'data' => $model->forwards,
                        'button' => [
                            'label' => '+{count}',
                            'popoverOptions' => ['html' => true]
                        ],
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
