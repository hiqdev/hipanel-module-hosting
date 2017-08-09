<?php

namespace hipanel\modules\hosting\grid;

use hipanel\widgets\gridLegend\BaseGridLegend;
use hipanel\widgets\gridLegend\GridLegendInterface;
use Yii;

class RequestGridLegend extends BaseGridLegend implements GridLegendInterface
{
    public function items()
    {
        return [
            [
                'label' => Yii::t('hipanel:hosting', 'Scheduled time:'),
                'tag' => 'h4',
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'Already'),
                'color' => '#E0E0E0',
                'rule' => false,
                'columns' => ['time'],
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'Deferred'),
                'color' => '#AAAAFF',
                'rule' => false,
                'columns' => ['time'],
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'State:'),
                'tag' => 'h4',
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'New'),
                'color' => '#FFFF99',
                'rule' => $this->model->state === 'new',
                'columns' => ['state'],
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'In progress'),
                'color' => '#AAFFAA',
                'rule' => $this->model->state === 'progress',
                'columns' => ['state'],
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'Done'),
                'columns' => ['state'],
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'Error'),
                'color' => '#FFCCCC',
                'rule' => $this->model->state === 'error',
                'columns' => ['state'],
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'Buzzed'),
                'color' => '#FFCCCC',
                'rule' => $this->model->state === 'buzzed',
                'columns' => ['state'],
            ],
        ];
    }
}