<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

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
                'rule' => $this->model->type === 'forward_only',
            ],
            [
                'label' => Yii::t('hipanel:hosting', 'Mail box with aliases'),
                'color' => '#FFFF99',
                'rule' => $this->model->type === 'mailbox_with_forwards',
            ],
        ];
    }
}
