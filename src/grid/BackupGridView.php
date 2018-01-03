<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\grid;

use hipanel\grid\ActionColumn;
use hipanel\grid\MainColumn;
use hipanel\modules\server\grid\ServerColumn;
use hipanel\widgets\obj\ObjLinkWidget;
use Yii;
use yii\helpers\Html;

class BackupGridView extends \hipanel\grid\BoxedGridView
{
    public function columns()
    {
        return array_merge(parent::columns(), [
            'id' => [
                'class' => MainColumn::class,
                'format' => 'html',
                'filterOptions' => ['class' => 'narrow-filter'],
            ],
            'object_id' => [
                'filterOptions' => ['class' => 'narrow-filter'],
            ],
            'backup' => [
                'class' => MainColumn::class,
                'filterAttribute' => 'backup_like',
            ],
            'server' => [
                'class' => ServerColumn::class,
            ],
            'account' => [
                'class' => AccountColumn::class,
            ],
            'object' => [
                'format' => 'raw',
                'attribute' => 'name',
                'filterAttribute' => 'name_like',
                'filterOptions' => ['class' => 'narrow-filter'],
                'value' => function ($model) {
                    return  Html::a($model->name, ['@backuping/view', 'id' => $model->object_id], ['class' => 'bold']) . ' ' .
                            ObjLinkWidget::widget(['model' => $model->getObj()]);
                },
            ],
            'name' => [
                'format' => 'raw',
                'attribute' => 'name',
                'value' => function ($model) {
                    return ObjLinkWidget::widget(['label' => $model->name, 'model' => $model->getObj()]);
                },
            ],
            'size' => [
                'format' => 'html',
                'filter' => false,
                'value' => function ($model) {
                    return Yii::$app->formatter->asShortSize($model->size, 2);
                },
            ],
            'time' => [
                'filter' => false,
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->time);
                },
            ],
            'actions' => [
                'class' => ActionColumn::class,
                'template' => '{view} {delete}',
            ],
            'inner_actions' => [
                'class' => ActionColumn::class,
                'template' => '{deleteBackup}',
                'buttons' => [
                    'deleteBackup' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-trash-o"></i>&nbsp;' . Yii::t('hipanel', 'Delete'), ['/hosting/backup/delete', 'id' => $model->id], [
                            'aria-label'   => Yii::t('hipanel', 'Delete'),
                            'class' => 'btn btn-danger btn-xs',
                            'data' => [
                                'confirm' => Yii::t('hipanel', 'Are you sure you want to delete this item?'),
                                'method'  => 'POST',
                                'data-pjax' => '0',
                            ],
                        ]);
                    },
                ],
            ],
        ]);
    }
}
