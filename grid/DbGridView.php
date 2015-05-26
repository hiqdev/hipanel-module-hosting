<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\grid;

use hipanel\grid\ActionColumn;
use hipanel\grid\BoxedGridView;
use hipanel\grid\MainColumn;
use hipanel\grid\EditableColumn;
use hipanel\grid\RefColumn;
use hipanel\modules\hosting\widgets\db\State;
use hipanel\modules\server\grid\ServerColumn;
use Yii;

class DbGridView extends BoxedGridView
{
    static public function defaultColumns()
    {
        return [
            'db'          => [
                'class'           => MainColumn::className(),
                'attribute'       => 'name',
                'filterAttribute' => 'name_like'
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
            'service_ip'  => [
                'filter' => false
            ],
            'description' => [
                'class'   => EditableColumn::className(),
                'filter'  => true,
                'popover' => Yii::t('app', 'Make any notes for your convenience'),
                'action'  => ['set-description'],
            ],
            'password'    => [
                'class'   => EditableColumn::className(),
                'filter'  => true,
                'popover' => Yii::t('app', 'Change the DB password'),
                'action'  => ['set-password'],
                'value'   => function () {
                    return Yii::t('app', 'Change password');
                }
            ],
            'actions'     => [
                'class'    => ActionColumn::className(),
                'template' => '{view} {update} {truncate} {delete}'
            ]
        ];
    }
}
