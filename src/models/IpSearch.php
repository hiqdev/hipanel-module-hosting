<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\models;

use hipanel\base\SearchModelTrait;
use yii\helpers\ArrayHelper;

class IpSearch extends Ip
{
    use SearchModelTrait {
        searchAttributes as defaultSearchAttributes;
    }

    /**
     * @inheritdoc
     */
    public function searchAttributes()
    {
        return ArrayHelper::merge($this->defaultSearchAttributes(),
            $this->buildAttributeConditions('server'),
            $this->buildAttributeConditions('tag'),
            [
                'with_tags',
                'with_counters',
                'with_expanded_ips',
                'show_only_device_link',
                'with_links',
                'not_tags',
                'soft_type',
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'server_in' => \Yii::t('hipanel/hosting', 'Servers'),
            'tag_in' => \Yii::t('hipanel/hosting', 'Tags'),
        ]);
    }
}
