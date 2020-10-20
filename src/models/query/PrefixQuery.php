<?php

namespace hipanel\modules\hosting\models\query;

use hiqdev\hiart\ActiveQuery;

class PrefixQuery extends ActiveQuery
{
    public function init()
    {
        parent::init();
        $this->andWhere(['is_ip' => false]);
    }

    public function withParent(): self
    {
        $this->joinWith('parent');
        $this->andWhere(['with_parent' => true]);

        return $this;
    }

    public function includeSuggestions(): self
    {
        $this->andWhere(['include_suggestions' => true]);

        return $this;
    }

    public function firstbornOnly(): self
    {
        $this->andWhere(['firstborn' => true]);

        return $this;
    }

    public function noParent(): self
    {
        $this->andWhere(['no_parent' => true]);

        return $this;
    }
}
