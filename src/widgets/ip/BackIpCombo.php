<?php

namespace hipanel\modules\hosting\widgets\ip;

use hiqdev\combo\Combo;
use yii\helpers\ArrayHelper;


/**
 * Class BackIpCombo
 */
class BackIpCombo extends HdomainIpCombo
{
    /** @inheritdoc */
    public $type = 'hosting/hdomain-backend-ip';

    /** @inheritdoc */
    public $name = 'hdomain-backend-ip';

    /** @inheritdoc */
    public function getFilter()
    {
        return ArrayHelper::merge(parent::getFilter(), [
            'soft_in'             => ['format' => ['apache','apache2']],
        ]);
    }
}