<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\models;

use Yii;

class Ip extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    public function rules () {
        return [
            [['id', 'client_id', 'seller_id'],                    'integer'],
            [['objects_count', 'client', 'seller'],               'safe'],
            [['prefix', 'family', 'tags'],                        'safe'],
            [['type', 'state', 'state_label'],                    'safe'],
            [['expanded_ips', 'ip_normalized'],                   'safe'],
            [['is_single'],                                       'boolean'],
            [['ip'], 'ip', 'subnet' => null, 'on' => ['create']],

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
        return $this->hasMany(Link::className(), ['ip_id' => 'id']);
    }
}
