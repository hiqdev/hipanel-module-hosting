<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

/**
 * @see    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\grid;

use hipanel\grid\MainColumn;
use hipanel\grid\RefColumn;
use hipanel\helpers\Url;
use hipanel\modules\server\grid\ServerColumn;
use hipanel\widgets\obj\ObjLabelWidget;
use hipanel\widgets\obj\ObjLinkWidget;
use hiqdev\xeditable\widgets\XEditable;
use Yii;
use yii\helpers\Html;

class BackupingGridView extends \hipanel\grid\BoxedGridView
{
    public $typeOptions = [];

    public function init()
    {
        parent::init();
        $controller = Yii::$app->controller;
        if (empty($this->typeOptions) && method_exists($controller, 'getTypeOptions')) {
            $this->typeOptions = (array) $controller->getTypeOptions();
        }
    }

    public function getTypeOptions()
    {
        $result = [];
        foreach ($this->typeOptions as $key => $value) {
            $result[$key] = Yii::t('hipanel.hosting.backuping.periodicity', $value);
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
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(Html::encode($model->name), ['@' . Html::encode($model->object) . '/view', 'id' => $model->id], ['class' => 'bold']);
                },
            ],
            'main' => [
                'attribute' => 'name',
                'filterAttribute' => 'name_like',
                'format' => 'raw',
                'value' => function ($model) {
                    return  Html::tag('span', Html::a(Html::encode($model->name), ['@backuping/view', 'id' => $model->id], ['class' => 'bold']) . ' ' .
                            ObjLinkWidget::widget(['model' => $model->getObj()]), ['style' => 'display: flex; justify-content: space-between;']);
                },
            ],
            'account' => [
                'attribute' => 'account_id',
                'class' => AccountColumn::class,
            ],
            'server' => [
                'attribute' => 'server',
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
                'format' => 'raw',
                'value' => static fn($model): string => (int) $model->backup_count > 0 ? Html::a(
                    Yii::t('hipanel:hosting', '{0, plural, one{# backup} other{# backups}}', (int) $model->backup_count),
                    Url::toRoute(['@backup/index', 'BackupSearch' => ['object_id' => $model->id]]),
                    ['target' => '_blank', 'data-pjax' => 0]
                ) : '',
            ],
            'type' => [
                'attribute' => 'type',
                'format' => 'raw',
                'filter' => false,
                'enableSorting' => false,
                'value' => fn($model) => XEditable::widget([
                    'model' => $model,
                    'attribute' => 'type',
                    'pluginOptions' => [
                        'type' => 'select',
                        'source' => $typeOptions,
                        'url' => Url::to('update'),
                        'data-display-value' => Yii::t('hipanel.hosting.backuping.periodicity', $model->type),
                    ],
                ]),
            ],
            'state_label' => [
                'class' => RefColumn::class,
                'i18nDictionary' => 'hipanel.hosting.backuping.periodicity',
                'attribute' => 'state_label',
                'filter' => false,
                'enableSorting' => false,
                'value' => static fn($model): string => Yii::t('hipanel:hosting', $model->state_label),
            ],
            'backup_last' => [
                'filter' => false,
                'format' => 'raw',
                'value' => fn($model) => implode(' ', [
                    Html::tag('nobr', $this->formatter->asDate($model->backup_last)),
                    Html::tag('nobr', $this->formatter->asTime($model->backup_last)),
                ]),
            ],
            'total_du' => [
                'filter' => false,
                'format' => 'raw',
                'value' => fn($model): string => $this->formatter->asShortSize($model->total_du, 2),
            ],
        ]);
    }
}
