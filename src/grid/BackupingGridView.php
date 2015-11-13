<?php
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
use yii\helpers\Html;

class BackupingGridView extends \hipanel\grid\BoxedGridView
{
    public static $typeOptions;

    /**
     * @param mixed $typeOptions
     */
    public static function setTypeOptions($typeOptions)
    {
        self::$typeOptions = $typeOptions;
    }

    static public function defaultColumns()
    {
        $typeOptions = self::$typeOptions;
        return [
            'name' => [
                'filterAttribute' => 'backuping_like',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a($model->name, [sprintf('/hosting/%s/view', $model->object), 'id' => $model->id], ['data-pjax' => 0, 'class' => 'bold']);
                }
            ],
            'account' => [
                'attribute' => 'account_id',
                'class' => AccountColumn::className(),
            ],
            'server' => [
                'attribute' => 'server_id',
                'class' => ServerColumn::className(),
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
                'value' => function($model) use ($typeOptions) {
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
            ],
            'total_du_gb' => [
                'filter' => false,
                'format' => 'html',
                'value' => function($model) {
                    return sprintf('%s&nbsp;GB', $model->total_du_gb);
                }
            ],
            'actions' => [
                'class' => ActionColumn::className(),
                'template' => '{view} {delete}',
            ],
        ];
    }
}
