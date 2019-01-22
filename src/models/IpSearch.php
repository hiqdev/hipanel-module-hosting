<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

/**
 * @see    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\models;

use hipanel\base\SearchModelTrait;
use Yii;
use yii\helpers\ArrayHelper;

class IpSearch extends Ip
{
    use SearchModelTrait {
        searchAttributes as defaultSearchAttributes;
    }

    /**
     * {@inheritdoc}
     */
    public function searchAttributes()
    {
        return ArrayHelper::merge(
            $this->defaultSearchAttributes(),
            $this->buildAttributeConditions('server'),
            $this->buildAttributeConditions('tag'),
            $this->buildAttributeConditions('soft'),
            $this->buildAttributeConditions('soft_type'),
            [
                'with_tags',
                'with_counters',
                'with_expanded_ips',
                'show_only_device_link',
                'with_links',
                'not_tags',
                'service_id',
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'server_in' => Yii::t('hipanel:hosting', 'Servers'),
            'tag_in' => Yii::t('hipanel:hosting', 'Tags'),
        ]);
    }
}
