<?php

namespace hipanel\modules\hosting\models\query;

use hiqdev\hiart\ActiveQuery;

class PrefixQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function withSuggestions(): self
    {
        $this->joinWith('suggestions');
        $this->andWhere(['with_suggestions' => true]);

        return $this;
    }
}
