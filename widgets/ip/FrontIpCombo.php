<?php

namespace hipanel\modules\hosting\widgets\ip;

use hiqdev\combo\Combo;
use yii\helpers\ArrayHelper;


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