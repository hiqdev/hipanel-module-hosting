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

namespace hipanel\modules\hosting\models;

use Yii;

class Soft extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    const TYPE_WEB = 'web';
    const TYPE_DB = 'db';
    const TYPE_LOGIN = 'login';

    /** @inheritdoc */
    public function rules()
    {
        return [
            [['id', 'no'], 'integer'],
            [['name', 'type', 'type_label', 'state', 'state_label'], 'safe'],
        ];
    }
}
