<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

/**
 * @see    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\models;

use hipanel\base\SearchModelTrait;
use hipanel\helpers\ArrayHelper;

class RequestSearch extends Request
{
    use SearchModelTrait {
        searchAttributes as defaultSearchAttributes;
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['ids'], 'safe', 'on' => ['search']],
            [['id_in'], 'safe'],
        ]);
    }
}
