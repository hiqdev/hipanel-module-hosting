<?php

/*
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\grid;

use hipanel\grid\ActionColumn;
use hipanel\grid\BoxedGridView;
use hipanel\grid\MainColumn;
use hipanel\grid\RefColumn;
use hipanel\grid\XEditableColumn;
use hipanel\modules\hosting\widgets\backup\BackupGridRow;
use hipanel\modules\hosting\widgets\db\State;
use hipanel\modules\server\grid\ServerColumn;
use Yii;

class DbGridView extends BoxedGridView
{
    public static function defaultColumns()
    {
        return [
            'name'          => [
                'class'           => MainColumn::className(),
                'format' => 'html',
                'attribute'       => 'name',
                'filterAttribute' => 'name_like'
            ],
            'state'       => [
                'class'  => RefColumn::className(),
                'i18nDictionary' => 'hipanel/hosting',
                'format' => 'raw',
                'value'  => function ($model) {
                    return State::widget(compact('model'));
                },
                'gtype'  => 'state,db',
            ],
            'account' => [
                'class' => AccountColumn::className()
            ],
            'server'      => [
                'class' => ServerColumn::className()
            ],
            'service_ip'  => [
                'filter' => false
            ],
            'description' => [
                'class' => XEditableColumn::class,
                'pluginOptions' => [
                    'url' => 'set-description',
                ],
                'filter'  => true,
                'popover' => Yii::t('app', 'Make any notes for your convenience'),
            ],
            'password' => [
                'class' => XEditableColumn::class,
                'pluginOptions' => [
                    'url' => 'set-password',
                ],
                'filter'  => true,
                'popover' => Yii::t('app', 'Change the DB password'),
                'value'   => function () {
                    return Yii::t('app', 'Change password');
                }
            ],
            'backups_widget' => [
                'label' => Yii::t('hipanel/hosting', 'Backups'),
                'format' => 'raw',
                'value' => function ($model) { return BackupGridRow::widget(['model' => $model]); }
            ],
            'actions'     => [
                'class'    => ActionColumn::className(),
                'template' => '{view} {delete}'
            ]
        ];
    }
}
