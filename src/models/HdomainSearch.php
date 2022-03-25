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
use hipanel\helpers\StringHelper;
use Yii;
use yii\helpers\ArrayHelper;

class HdomainSearch extends Hdomain
{
    use SearchModelTrait {
        searchAttributes as defaultSearchAttributes;
        rules as defaultRules;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return ArrayHelper::merge(self::defaultRules(), [
            [
                ['domain_in'],
                'filter',
                'filter' => function ($value) {
                    return is_array($value) ? $value : StringHelper::explode((string)$value);
                },
            ],
        ]);
    }

    /**
     * {@inheritdoc}
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

    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'domain_in' => Yii::t('hipanel:hosting', 'Domain list (comma-separated)'),
        ]);
    }
}
