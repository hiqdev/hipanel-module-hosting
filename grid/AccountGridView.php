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

class AccountGridView extends \hipanel\grid\BoxedGridView
{
    static public function defaultColumns()
    {
        return [
            'account' => [
                'class'                 => MainColumn::className(),
                'attribute'             => 'login',
                'filterAttribute'       => 'account_like',
            ],
            'state'       => [
                'class'  => RefColumn::className(),
                'format' => 'raw',
                'value'  => function ($model) {
                    return State::widget(compact('model'));
                },
                'gtype'  => 'state,db',
            ],
            'server'      => [
                'class' => ServerColumn::className()
            ],
            'actions'     => [
                'class'    => ActionColumn::className(),
                'template' => '{view} {update} {delete}'
            ],

        ];
    }
}
