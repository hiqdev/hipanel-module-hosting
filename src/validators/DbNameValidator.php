<?php

/*
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\validators;

use yii\validators\RegularExpressionValidator;

/**
 * Class LoginValidator is used to validate logins of clients
 */
class DbNameValidator extends RegularExpressionValidator
{
    /**
     * @inheritdoc
     */
    public $pattern = '/^[a-z0-9_-]{2,31}$/';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->message = \Yii::t('app', '{attribute} should contain only letters, digits, underscores or hyphens and be at least 2 symbols length');
    }
}
