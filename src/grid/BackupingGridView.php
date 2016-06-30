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
use hipanel\grid\MainColumn;
use hipanel\helpers\Url;
use hipanel\modules\hosting\widgets\backup\ObjectLabelWidget;
use hipanel\modules\server\grid\ServerColumn;
use hiqdev\xeditable\widgets\XEditable;
use Yii;
use yii\helpers\Html;

class BackupingGridView extends \hipanel\grid\BoxedGridView
{
    public static $typeOptions;

    /**
     * @param mixed $typeOptions
     */
    public static function setTypeOptions($typeOptions)
    {
        foreach ($typeOptions as $key => &$value) {
            $value = Yii::t('hipanel/hosting/backuping/periodicity', $value);
        }

        self::$typeOptions = $typeOptions;
    }

    public static function defaultColumns()
    {
        $typeOptions = self::$typeOptions;

        return [
            'name' => [
                'class' => MainColumn::class,
                'filterAttribute' => 'name_like',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a($model->name, ['@' . $model->object . '/view', 'id' => $model->id], ['class' => 'bold']);
                },
            ],
            'main' => [
                'attribute' => 'name',
                'filterAttribute' => 'name_like',
                'format' => 'raw',
                'value' => function ($model) {
                    return  Html::a($model->name, ['@backuping/view', 'id' => $model->id], ['class' => 'bold']) . ' ' .
                            Html::a(ObjectLabelWidget::widget(compact('model')), ['@' . $model->object . '/view', 'id' => $model->id]);
                },
            ],
            'account' => [
                'attribute' => 'account_id',
                'class' => AccountColumn::class,
            ],
            'server' => [
                'attribute' => 'server_id',
                'class' => ServerColumn::class,
            ],
            'object' => [
                'filter' => false,
                'format' => 'raw',
                'value' => function ($model) {
                    return ObjectLabelWidget::widget(compact('model'));
                }
            ],
            'backup_count' => [
                'filter' => false,
            ],
            'type' => [
                'attribute' => 'type',
                'format' => 'raw',
                'filter' => false,
                'enableSorting' => false,
                'value' => function ($model) use ($typeOptions) {
                    return XEditable::widget([
                        'model' => $model,
                        'attribute' => 'type',
                        'pluginOptions' => [
                            'type' => 'select',
                            'source' => $typeOptions,
                            'url' => Url::to('update'),
                        ]
                    ]);
                }
            ],
            'state_label' => [
                'filter' => false,
                'enableSorting' => false,
            ],
            'backup_last' => [
                'filter' => false,
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::tag('nobr', Yii::$app->formatter->asDate($model->backup_last)) . ' ' .
                           Html::tag('nobr', Yii::$app->formatter->asTime($model->backup_last));
                },
            ],
            'total_du' => [
                'filter' => false,
                'format' => 'html',
                'value' => function ($model) {
                    return Yii::$app->formatter->asShortSize($model->total_du, 2);
                }
            ],
            'actions' => [
                'class' => ActionColumn::class,
                'template' => '{view} {delete}',
            ],
        ];
    }
}
