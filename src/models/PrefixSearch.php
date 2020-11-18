<?php

namespace hipanel\modules\hosting\models;

use hipanel\base\SearchModelTrait;
use hipanel\helpers\ArrayHelper;
use Yii;

class PrefixSearch extends Prefix
{
    use SearchModelTrait {
        searchAttributes as defaultSearchAttributes;
    }

    public function searchAttributes(): array
    {
        return ArrayHelper::merge($this->defaultSearchAttributes(), [
            'is_ip',
            'ip_cntd',
            'ip_cntd_eql',
            'ip_cnts',
            'ip_cnts_eql',
            'ip_cnts_cntd',

            'with_parent',
            'include_suggestions',
            'firstborn',
            'family',
        ]);
    }

    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'family' => Yii::t('hipanel.hosting.ipam', 'Family'),
        ]);
    }
}
