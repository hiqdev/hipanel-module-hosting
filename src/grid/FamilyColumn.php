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
use yii\helpers\IpHelper;

class FamilyColumn extends DataColumn
{
    public function init()
    {
        parent::init();
        $this->label = Yii::t('hipanel.hosting.ipam', 'Family');
    }

    public function getDataCellValue($model, $key, $index)
    {
        return sprintf('IPv%d', IpHelper::getIpVersion($model->ip));
    }
}
