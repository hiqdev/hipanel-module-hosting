<?php

/*
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\models;

use hipanel\helpers\ArrayHelper;
use hipanel\validators\DomainValidator;
use Yii;
use yii\helpers\StringHelper;
use yii\validators\IpValidator;

class Ip extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait {
        attributes as defaultAttributes;
    }

    /**
     * @var string
     */
    public static $i18nDictionary = 'hipanel/hosting';

    /**
     * @var Link[] Array of links to be inserted/updated.
     * Do not mix up with [[getLinks]]
     * @see getAddedLinks
     */
    private $_links = [];

    public function attributes()
    {
        $attributes = $this->defaultAttributes();
        unset($attributes[array_search('links', $attributes, true)]);
        return $attributes;
    }

    public function setOldAttribute($name, $value)
    {
        if ($name !== 'links') {
            parent::setOldAttribute($name, $value);
        }
    }

    public function rules()
    {
        return [
            [['client_id', 'seller_id'],                          'integer'],
            [['objects_count', 'client', 'seller'],               'safe'],
            [['prefix', 'family', 'tags'],                        'safe'],
            [['type', 'state', 'state_label', 'ptr'],             'safe'],
            [['expanded_ips', 'ip_normalized'],                   'safe'],
            [['is_single'],                                       'boolean'],
            [['ip'], 'ip', 'subnet' => null, 'on' => ['create']],
            [['ip'], 'safe', 'on' => ['update']],
            [['links'], 'safe', 'on' => ['create', 'update']],
            [['tags'], 'filter',
                'filter' => function ($value) {
                    return StringHelper::explode($value);
                },
                'skipOnArray' => true, 'on' => ['create', 'update']
            ],
            [['id'], 'required', 'on' => ['update', 'delete', 'set-ptr']],
            [['id'], 'integer', 'on' => ['create', 'update', 'delete', 'expand']],
            [['with_existing'], 'boolean', 'on' => ['expand']],
            [['ptr'], DomainValidator::class, 'on' => ['set-ptr']],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'links'                 => Yii::t(static::$i18nDictionary, 'Links'),
            'objects_count'         => Yii::t(static::$i18nDictionary, 'Count of objects'),
            'is_single'             => Yii::t(static::$i18nDictionary, 'Single'),
            'ip_normalized'         => Yii::t(static::$i18nDictionary, 'Normalized IP'),
            'expanded_ips'          => Yii::t(static::$i18nDictionary, 'Expanded IPs'),
            'ptr'                   => Yii::t(static::$i18nDictionary, 'PTR')
        ]);
    }

    /**
     * @return array|\hiqdev\hiart\ActiveQuery
     */
    public function getLinks()
    {
        return in_array($this->scenario, ['create', 'update'], true)
            ? ArrayHelper::toArray($this->_links)
            : $this->hasMany(Link::className(), ['ip_id' => 'id']);
    }

    /**
     * @return \hiqdev\hiart\ActiveQuery
     */
    public function getRelatedLinks()
    {
        return $this->hasMany(Link::className(), ['ip_id' => 'id']);
    }

    /**
     * @return Link[]
     */
    public function getAddedLinks()
    {
        return $this->_links;
    }

    /**
     * @param array $links
     */
    public function setAddedLinks(array $links)
    {
        foreach ($links as $link) {
            $this->addLink($link);
        }
    }

    /**
     * @param Link $link
     */
    public function addLink(Link $link)
    {
        $this->_links[] = $link;
    }

    /**
     * Checks, whether it is possible to set a PTR record on the IP address
     *
     * @return bool
     */
    public function canSetPtr()
    {
        return !in_array('aux', (array) $this->tags, true)
            && (new IpValidator(['ranges' => ['!system', 'any']]))->validate($this->ip);
    }
}
