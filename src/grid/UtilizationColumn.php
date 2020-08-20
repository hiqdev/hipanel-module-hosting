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

use hiqdev\higrid\DataColumn;
use Yii;
use yii\bootstrap\Progress;

class UtilizationColumn extends DataColumn
{
    public $format = 'html';

    public function init()
    {
        parent::init();
        $this->label = Yii::t('hipanel.hosting.ipam', 'Utilization');
    }

    public function getDataCellValue($model, $key, $index)
    {
        $prc = mt_rand(1, 84);

        return Progress::widget([
            'percent' => $prc,
            'label' => $prc . '%',
            'barOptions' => ['class' => 'progress-bar-success'],
            'options' => ['style' => 'background-color: grey;'],
        ]);
    }
}
