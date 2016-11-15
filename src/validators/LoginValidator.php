<?php

/*
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\validators;

/**
 * Class LoginValidator is used to validate logins of accounts
 */
class LoginValidator extends \yii\validators\RegularExpressionValidator
{
    /**
     * @inheritdoc
     */
    public $pattern = '/^[a-z][a-z0-9_]{2,31}$/';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->message = \Yii::t('hipanel:hosting', '{attribute} should begin with a letter, contain only letters, digits or underscores and be at least 2 symbols length');
    }
}
