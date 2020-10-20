<?php

namespace hipanel\modules\hosting\models\query;

use hiqdev\hiart\ActiveQuery;

class AddressQuery extends ActiveQuery
{
    public function init()
    {
        parent::init();
        $this->andWhere(['is_ip' => true]);
    }

    public function withParent(): self
    {
        $this->joinWith('parent');
        $this->andWhere(['with_parent' => true]);

        return $this;
    }
}
