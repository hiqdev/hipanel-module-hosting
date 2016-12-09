<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\widgets\ip;

use yii\helpers\ArrayHelper;

/**
 * Class BackIpCombo.
 */
class BackIpCombo extends HdomainIpCombo
{
    /** {@inheritdoc} */
    public $type = 'hosting/hdomain-backend-ip';

    /** {@inheritdoc} */
    public $name = 'hdomain-backend-ip';

    /** {@inheritdoc} */
    public function getFilter()
    {
        return ArrayHelper::merge(parent::getFilter(), [
            'soft_in'             => ['format' => ['apache', 'apache2']],
        ]);
    }
}
