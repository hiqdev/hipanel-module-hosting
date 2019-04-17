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

use hipanel\modules\hosting\menus\CrontabActionsMenu;
use hipanel\modules\server\grid\ServerColumn;
use hiqdev\yii2\menus\grid\MenuColumn;
use Yii;
use yii\helpers\Html;

class CrontabGridView extends \hipanel\grid\BoxedGridView
{
    public function columns()
    {
        return array_merge(parent::columns(), [
            'crontab' => [
                'attribute' => 'crontab',
                'format' => 'html',
                'enableSorting' => false,
                'value' => function ($model, $key, $index) {
                    $label = Yii::t('hipanel:hosting', '{0, plural, one{# record} other{# records}}', $model->cronRecordCount);

                    return Html::a($label, ['view', 'id' => $key], ['class' => 'bold', 'data-pjax' => 0]);
                },
            ],
            'server' => [
                'sortAttribute' => 'server',
                'attribute' => 'server_id',
                'class' => ServerColumn::class,
            ],
            'account' => [
                'sortAttribute' => 'account',
                'attribute' => 'account_id',
                'class' => AccountColumn::class,
            ],
            'client',
            'state' => [
                'enableSorting' => false,
                'attribute' => 'state',
                'value' => function ($model) {
                    return Yii::t('hipanel:hosting:cron:states', $model->state);
                },
            ],
            'actions' => [
                'class' => MenuColumn::class,
                'menuClass' => CrontabActionsMenu::class,
            ],
        ]);
    }
}
