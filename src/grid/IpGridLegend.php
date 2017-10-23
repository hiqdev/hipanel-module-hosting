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
