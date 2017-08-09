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
                'label' => Yii::t('hipanel:hosting', 'Already'),
                'color' => '#E0E0E0',
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'Deferred'),
                'color' => '#AAAAFF',
                'rule' => $this->model->type === 'free',
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'New'),
                'color' => '#FFFF99',
                'rule' => $this->model->state === 'new',
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'In progress'),
                'color' => '#AAFFAA',
                'rule' => $this->model->state === 'progress',
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'Done'),
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'Error'),
                'color' => '#FFCCCC',
                'rule' => $this->model->state === 'error',
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'Buzzed'),
                'color' => '#FFCCCC',
                'rule' => $this->model->state === 'buzzed',
            ],
        ];
    }
}