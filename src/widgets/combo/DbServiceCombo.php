<?php

/*
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\widgets\combo;

/**
 * Class DbService
 */
class DbServiceCombo extends ServiceCombo
{
    /** @inheritdoc */
    public $type = 'hosting/service/db';

    /** @inheritdoc */
    public $softType = 'db';
}
