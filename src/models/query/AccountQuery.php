<?php
/**
 * Hosting module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\models\query;

use hiqdev\hiart\ActiveQuery;

/**
 * Class AccountQuery
 * @package hipanel\modules\hosting\models\query
 */
class AccountQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function withValues(): self
    {
        $this->joinWith('values');
        $this->andWhere(['with_values' => true]);

        return $this;
    }
}
