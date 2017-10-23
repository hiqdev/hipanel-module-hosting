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

class HdomainGridLegend extends BaseGridLegend implements GridLegendInterface
{
    public function items()
    {
        return [
            [
                'label' => Yii::t('hipanel:hosting', 'Domain'),
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'DNS records'),
                'color' => '#CCFFCC',
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'Alias'),
                'color' => '#CCCCFF',
                'rule' => $this->model->vhost_id !== null,
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'Name server'),
                'color' => '#FFFFCC',
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'Complex domain'),
            ],
        ];
    }
}
