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
use hipanel\modules\hosting\models\Mail;
use hipanel\modules\hosting\widgets\mail\State;
use hipanel\modules\hosting\widgets\mail\Type;
use hipanel\modules\server\grid\ServerColumn;
use hipanel\widgets\ArraySpoiler;
use hipanel\widgets\Label;
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
            'domain' => [
                'attribute' => 'hdomain_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->domain, ['@hdomain/view', 'id' => $model->hdomain_id]);
                }
            ],
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
                        'visibleCount' => 2,
                        'data' => $model->forwards,
                        'button' => [
                            'label' => '+{count}',
                            'popoverOptions' => ['html' => true]
                        ],
                    ]);
                }
            ],
            'spam_action' => [
                'format' => 'raw',
                'value' => function ($model) {
                    /** @var $model Mail */
                    if ($model->spam_action === $model::SPAM_ACTION_DELETE) {
                        return Label::widget([
                            'color' => 'danger',
                            'label' => Yii::t('app', 'Delete')
                        ]);
                    } elseif ($model->spam_action === '') {
                        return Label::widget([
                            'color' => 'info',
                            'label' => Yii::t('app', 'Do nothing')
                        ]);
                    } else {
                        return Label::widget([
                            'color' => 'primary',
                            'label' => Yii::t('app', 'Forward to')
                        ]) . ' ' . ArraySpoiler::widget([
                            'data' => $model->spam_action,
                            'visibleCount' => 2
                        ]);
                    }
                }
            ],
            'actions' => [
                'class' => ActionColumn::className(),
                'template' => '{view} {delete}'
            ],
        ];
    }
}
