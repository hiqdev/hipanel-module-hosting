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
    public function columns()
    {
        return array_merge(parent::columns(), [
            'mail' => [
                'class' => MainColumn::class,
                'filterAttribute' => 'mail_like',
            ],
            'state' => [
                'class' => RefColumn::class,
                'i18nDictionary' => 'hipanel:hosting',
                'format' => 'raw',
                'value' => function ($model) {
                    return State::widget(compact('model'));
                },
                'gtype' => 'state,mail',
            ],
            'server' => [
                'class' => ServerColumn::class,
            ],
            'du_limit' => [
                'attribute' => 'du_limit',
                'format' => 'raw',
                'value' => function ($model) {
                    return !empty($model->du_limit) ? Html::encode($model->du_limit) . 'MB' : '';
                },
            ],
            'domain' => [
                'attribute' => 'hdomain_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(Html::encode($model->domain), ['@hdomain/view', 'id' => $model->hdomain_id]);
                },
            ],
            'type' => [
                'format' => 'raw',
                'filter' => function ($column, $model, $attribute) {
                    return Html::activeDropDownList($model, $attribute, ['' => '----------'] + Mail::getTypes(), [
                        'class' => 'form-control',
                    ]);
                },
                'value' => function ($model) {
                    return Type::widget(['model' => $model, 'label' => $model->type]);
                },
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
                            'popoverOptions' => ['html' => true],
                        ],
                    ]);
                },
            ],
            'account' => ['class' => AccountColumn::class],
            'spam_action' => [
                'format' => 'raw',
                'value' => function ($model) {
                    /** @var $model Mail */
                    if ($model->spam_action === $model::SPAM_ACTION_DELETE) {
                        return Label::widget([
                            'color' => 'danger',
                            'label' => Yii::t('hipanel', 'Delete'),
                        ]);
                    } elseif ($model->spam_action === '') {
                        return Label::widget([
                            'color' => 'info',
                            'label' => Yii::t('hipanel:hosting', 'Do nothing'),
                        ]);
                    } else {
                        return Label::widget([
                                'color' => 'primary',
                                'label' => Yii::t('hipanel:hosting', 'Forward to'),
                            ]) . ' ' . ArraySpoiler::widget([
                                'data' => $model->spam_action,
                                'visibleCount' => 2,
                            ]);
                    }
                },
            ],
            'actions' => [
                'class' => ActionColumn::class,
                'template' => '{view} {delete}',
            ],
        ]);
    }
}
