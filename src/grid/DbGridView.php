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
use hipanel\grid\BoxedGridView;
use hipanel\grid\MainColumn;
use hipanel\grid\RefColumn;
use hipanel\grid\XEditableColumn;
use hipanel\modules\hosting\models\Db;
use hipanel\modules\hosting\widgets\backup\BackupGridRow;
use hipanel\modules\hosting\widgets\db\State;
use hipanel\modules\server\grid\ServerColumn;
use Yii;
use yii\helpers\Html;

class DbGridView extends BoxedGridView
{
    public function columns()
    {
        return array_merge(parent::columns(), [
            'name'          => [
                'class'           => MainColumn::class,
                'format' => 'html',
                'attribute'       => 'name',
                'filterAttribute' => 'name_like',
            ],
            'state'       => [
                'class'  => RefColumn::class,
                'i18nDictionary' => 'hipanel:hosting',
                'value'  => function ($model) {
                    return State::widget(compact('model'));
                },
                'gtype'  => 'state,db',
            ],
            'account' => [
                'class' => AccountColumn::class,
            ],
            'server'      => [
                'class' => ServerColumn::class,
            ],
            'service_ip'  => [
                'filter' => false,
            ],
            'description' => [
                'class' => XEditableColumn::class,
                'pluginOptions' => [
                    'url' => 'set-description',
                ],
                'filter'  => true,
                'popover' => Yii::t('hipanel', 'Make any notes for your convenience'),
            ],
            'password' => [
                'class' => XEditableColumn::class,
                'pluginOptions' => [
                    'url' => 'set-password',
                ],
                'filter'  => true,
                'popover' => Yii::t('hipanel', 'Change password'),
                'value'   => function () {
                    return Yii::t('hipanel', 'Change password');
                },
            ],
            'backups_widget' => [
                'label' => Yii::t('hipanel:hosting', 'Backups'),
                'format' => 'html',
                'value' => function ($model) {
                    return BackupGridRow::widget(['model' => $model]);
                },
            ],
            'info_server' => [
                'label' => Yii::t('hipanel:hosting', 'Server'),
                'format' => 'html',
                'value' => function (Db $model): string {
                    return Yii::t('hipanel:hosting', '{host_label} {host} {dbms_label} {dbms}', [
                        'host_label' => Html::tag('b', Yii::t('hipanel:hosting', 'Host:')),
                        'host' => $model->service_ip,
                        'dbms_label' => Html::tag('b', Yii::t('hipanel:hosting', 'DBMS:')),
                        'dbms' => $model->service,
                    ]);
                },
            ],
            'access' => [
                'label' => Yii::t('hipanel:hosting', 'Access credentials'),
                'format' => 'html',
                'value' => function (DB $model): string {
                    return Yii::t('hipanel:hosting', '{login_label} {login}', [
                        'login_label' => Html::tag('b', Yii::t('hipanel:hosting', 'Login:')),
                        'login' => $model->name,
                    ]);
                },
            ],
            'actions'     => [
                'class'    => ActionColumn::class,
                'template' => '{view} {delete}',
            ],
        ]);
    }
}
