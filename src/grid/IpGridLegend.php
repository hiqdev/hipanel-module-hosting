<?php

namespace hipanel\modules\hosting\grid;

use hipanel\widgets\gridLegend\BaseGridLegend;
use hipanel\widgets\gridLegend\GridLegendInterface;
use Yii;

class IpGridLegend extends BaseGridLegend implements GridLegendInterface
{
    public function items()
    {
        return [
            [
                'label' => Yii::t('hipanel:hosting', 'Shared'),
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'Free'),
                'color' => '#AAFFAA',
                'rule' => $this->model->type === 'free',
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'Dedicated'),
                'color' => '#CCCCFF',
                'rule' => $this->model->type === 'dedicated',
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'System'),
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'Blocked'),
            ],
        ];
    }
}
