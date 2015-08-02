<?php

namespace hipanel\modules\hosting\widgets\combo;

use hiqdev\combo\Combo;
use yii\helpers\ArrayHelper;

/**
 * Class Account
 */
class SshAccountCombo extends AccountCombo
{
    /** @inheritdoc */
    public $accountType = 'user';
}