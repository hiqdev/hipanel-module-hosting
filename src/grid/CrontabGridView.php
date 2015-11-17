<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\grid;

use hipanel\grid\ActionColumn;
use hipanel\modules\server\grid\ServerColumn;
use Yii;
use yii\helpers\Html;

class CrontabGridView extends \hipanel\grid\BoxedGridView
{
    static public function defaultColumns()
    {
        return [
            'crontab' => [
                'attribute' => 'crontab',
                'format' => 'html',
                'enableSorting' => false,
                'value' => function($model, $key, $index) {
                    $label = Yii::t('app', '{0, plural, one{# record} other{# records}}', $model->cronRecordCount);
                    return Html::a($label, ['view', 'id' => $key], ['class' => 'bold', 'data-pjax' => 0]);
                }
            ],
            'server' => [
                'sortAttribute' => 'server',
                'attribute' => 'server_id',
                'class' => ServerColumn::className(),
            ],
            'account' => [
                'sortAttribute' => 'account',
                'attribute' => 'account_id',
                'class' => AccountColumn::className()
            ],
            'client',
            'state' => [
                'enableSorting' => false,
                'attribute' => 'state',
            ],
            'actions' => [
                'class' => ActionColumn::className(),
                'template' => '{view}',
            ],
        ];
    }
}
