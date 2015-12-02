<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\models;

use hipanel\helpers\ArrayHelper;
use Yii;

class Ip extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait {
        attributes as defaultAttributes;
    }

    /**
     * @var Link[] Array of links to be inserted/updated.
     * Do not mix up with [[getLinks]]
     * @see getAddedLinks
     */
    private $_links = [];

    public function attributes()
    {
        $attributes = $this->defaultAttributes();
        unset($attributes[array_search('links', $attributes)]);
        return $attributes;
    }

    public function rules () {
        return [
            [['id', 'client_id', 'seller_id'],                    'integer'],
            [['objects_count', 'client', 'seller'],               'safe'],
            [['prefix', 'family', 'tags'],                        'safe'],
            [['type', 'state', 'state_label'],                    'safe'],
            [['expanded_ips', 'ip_normalized'],                   'safe'],
            [['is_single'],                                       'boolean'],
            [['ip'], 'ip', 'subnet' => null, 'on' => ['create']],
            [['links'], 'safe', 'on' => ['create', 'update']],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels () {
        return $this->mergeAttributeLabels([
            'objects_count'         => Yii::t('app', 'Count of objects'),
            'is_single'             => Yii::t('app', 'Single'),
            'ip_normalized'         => Yii::t('app', 'Normalized IP'),
            'expanded_ips'          => Yii::t('app', 'Expanded IPs'),
        ]);
    }

    public function getLinks() {
        return in_array($this->scenario, ['create', 'update'])
            ? ArrayHelper::toArray($this->_links)
            : $this->hasMany(Link::className(), ['ip_id' => 'id']);
    }

    public function getAddedLinks() {
        return $this->_links;
    }

    /**
     * @param Link $link
     */
    public function addLink(Link $link) {
        $this->_links[] = $link;
    }
}
