<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\models;

use hipanel\base\SearchModelTrait;
use hipanel\helpers\StringHelper;
use yii\helpers\ArrayHelper;

class HdomainSearch extends Hdomain {
    use SearchModelTrait {
        searchAttributes as defaultSearchAttributes;
        rules as defaultRules;
    }

    public function rules() {
        return ArrayHelper::merge(self::defaultRules(), [
            [
                ['domain_in'],
                'filter',
                'filter' => function ($value) { return is_array($value) ? $value : StringHelper::explode($value); }
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function searchAttributes()
    {
        return ArrayHelper::merge($this->defaultSearchAttributes(), [
            'with_aliases',
            'with_request',
            'with_vhosts',
            'with_dns',
            'show_aliases_only',
        ]);
    }
}
