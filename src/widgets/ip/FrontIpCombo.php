<?php

/*
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\widgets\ip;

use hiqdev\combo\Combo;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * Class FrontIpCombo
 */
class FrontIpCombo extends HdomainIpCombo
{
    /** @inheritdoc */
    public $type = 'hosting/hdomain-frontend-ip';

    /** @inheritdoc */
    public $name = 'hdomain-frontend-ip';

    /** @inheritdoc */
    public function getFilter()
    {
        return ArrayHelper::merge(parent::getFilter(), [
            'soft_in'             => ['format' => ['nginx']],
        ]);
    }
}
