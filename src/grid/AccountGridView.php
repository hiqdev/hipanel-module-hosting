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
use hipanel\modules\hosting\models\Account;
use hipanel\modules\hosting\widgets\account\State;
use hipanel\modules\hosting\widgets\account\Type;
use hipanel\modules\server\grid\ServerColumn;
use hipanel\widgets\ArraySpoiler;
use Yii;
use yii\helpers\Html;

class AccountGridView extends \hipanel\grid\BoxedGridView
{
    public function columns()
    {
        return array_merge(parent::columns(), [
            'account' => [
                'class'             => MainColumn::class,
                'label'             => Yii::t('hipanel', 'Account'),
                'attribute'         => 'login',
                'filterAttribute'   => 'login_like',
            ],
            'state' => [
                'class'             => RefColumn::class,
                'format'            => 'raw',
                'i18nDictionary'    => 'hipanel:hosting',
                'value'             => function ($model) {
                    return State::widget(compact('model'));
                },
                'gtype'             => 'state,account',
            ],
            'server' => [
                'class'             => ServerColumn::class,
            ],
            'sshftp_ips' => [
                'attribute'         => 'sshftp_ips',
                'format'            => 'raw',
                'value'             => function ($model) {
                    return ArraySpoiler::widget([
                        'data'         => $model->sshftp_ips,
                        'visibleCount' => 3,
                    ]);
                },
            ],
            'actions' => [
                'class'             => ActionColumn::class,
                'template'          => '{view} {delete}',
            ],
            'type' => [
                'class'             => RefColumn::class,
                'i18nDictionary'    => 'hipanel:hosting',
                'format'            => 'raw',
                'value'             => function ($model) {
                    return Type::widget(compact('model'));
                },
                'gtype'             => 'type,account',
            ],
            'access_data' => [
                'format' => 'raw',
                'label' => Yii::t('hipanel:hosting:account', 'Access data'),
                'value' => function (Account $model): string {
                    return Yii::t('hipanel:hosting:account', '{ip_label} {ip} {login_label} {login}', [
                        'ip_label' => Html::tag('b', Yii::t('hipanel', 'IP:')),
                        'login_label' => Html::tag('b', Yii::t('hipanel', 'Login:')),
                        'ip' => Html::encode($model->ip),
                        'login' => Html::encode($model->login),
                    ]);
                },
            ],
        ]);
    }
}
