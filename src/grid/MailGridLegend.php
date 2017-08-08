<?php

namespace hipanel\modules\hosting\grid;

use hipanel\widgets\gridLegend\BaseGridLegend;
use hipanel\widgets\gridLegend\GridLegendInterface;
use Yii;

class MailGridLegend extends BaseGridLegend implements GridLegendInterface
{
    public function items()
    {
        return [
            [
                'label' => Yii::t('hipanel:hosting', 'Mail box'),
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'Mail alias'),
                'color' => '#CCCCFF',
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'Mail box with aliases'),
                'color' => '#FFFF99',
            ],
        ];
    }
}
