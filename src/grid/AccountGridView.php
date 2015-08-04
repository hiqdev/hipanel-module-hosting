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
use hipanel\modules\hosting\widgets\account\State;
use hipanel\modules\server\grid\ServerColumn;
use hipanel\widgets\ArraySpoiler;

class AccountGridView extends \hipanel\grid\BoxedGridView
{
    static public function defaultColumns()
    {
        return [
            'account'    => [
                'class'           => MainColumn::className(),
                'attribute'       => 'login',
                'filterAttribute' => 'login_like',
            ],
            'state'      => [
                'class'  => RefColumn::className(),
                'format' => 'raw',
                'value'  => function ($model) {
                    return State::widget(compact('model'));
                },
                'gtype'  => 'state,db',
            ],
            'server'     => [
                'class' => ServerColumn::className()
            ],
            'sshftp_ips' => [
                'attribute' => 'sshftp_ips',
                'format'    => 'raw',
                'value'     => function ($model) {
                    return ArraySpoiler::widget([
                        'data'         => $model->sshftp_ips,
                        'visibleCount' => 3
                    ]);
                }
            ],
            'actions'    => [
                'class'    => ActionColumn::className(),
                'template' => '{view} {update} {delete}'
            ],
        ];
    }
}
