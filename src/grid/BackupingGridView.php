<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

/**
 * @see    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\grid;

use hipanel\grid\MainColumn;
use hipanel\helpers\Url;
use hipanel\widgets\obj\ObjLabelWidget;
use hipanel\modules\server\grid\ServerColumn;
use hiqdev\xeditable\widgets\XEditable;
use Yii;
use yii\helpers\Html;

class BackupingGridView extends \hipanel\grid\BoxedGridView
{
    public $typeOptions;

    public function getTypeOptions()
    {
        $result = [];
        foreach ($this->typeOptions as $key => $value) {
            $result[$key] = Yii::t('hipanel:hosting:backuping:periodicity', $value);
        }

        return $result;
    }

    public function columns()
    {
        $typeOptions = $this->getTypeOptions();

        return array_merge(parent::columns(), [
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
                            ObjLinkWidget::widget(['model' => $model->getObj()]);
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
                    return ObjLabelWidget::widget(['model' => $model->getObj()]);
                },
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
                        ],
                    ]);
                },
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
                },
            ],
        ]);
    }
}
