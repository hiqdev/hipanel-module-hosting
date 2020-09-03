<?php

namespace hipanel\modules\hosting\models;

use hipanel\base\SearchModelTrait;
use hipanel\helpers\ArrayHelper;

class PrefixSearch extends Prefix
{
    use SearchModelTrait {
        searchAttributes as defaultSearchAttributes;
    }

    /**
     * {@inheritdoc}
     */
    public function searchAttributes()
    {
        return ArrayHelper::merge($this->defaultSearchAttributes(), [
            'is_ip',
            'ip_cntd',
            'ip_cntd_eql',
            'ip_cnts',
            'ip_cnts_eql',
            'ip_cnts_cntd',
        ]);
    }
}
