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
use Yii;

class BackupingSearch extends Backuping
{
    use SearchModelTrait {
        searchAttributes as defaultSearchAttributes;
        rules as defaultRules;
    }

    public function rules()
    {
        return ArrayHelper::merge($this->defaultRules(), [
            [['period'], 'string', 'skipOnEmpty' => true],
        ]);
    }

    public function searchAttributes()
    {
        return ArrayHelper::merge($this->defaultSearchAttributes(), [
            'object',
            'period',
        ]);
    }

    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'period' => Yii::t('hipanel:hosting', 'Period'),
        ]);
    }
}
