<?php

namespace hipanel\modules\hosting\grid;

use hipanel\grid\DataColumn;
use hipanel\modules\hosting\widgets\ip\IpTag;
use Yii;
use yii\helpers\Html;

class TagsColumn extends DataColumn
{
    public $format = 'raw';

    public $attribute = 'tags';

    public function init()
    {
        parent::init();
        $this->label = Yii::t('hipanel.hosting.ipam', 'Tags');
        $this->filter = static fn($column, $model) => Html::activeDropDownList(
            $model,
            'tags',
            array_merge(['' => Yii::t('hipanel', '--')], $model->getTagOptions()),
            ['class' => 'form-control']
        );
    }

    public function getDataCellValue($model, $key, $index)
    {
        $labels = [];
        foreach ($model->tags as $tag) {
            $labels[] = IpTag::widget(['tag' => $tag]);
        }

        return implode(' ', $labels);
    }
}