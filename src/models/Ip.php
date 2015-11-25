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
            [['ip', 'objects_count', 'tags', 'client', 'seller'], 'safe'],
            [['prefix', 'family'],                                'safe'],
            [['type', 'state', 'state_label'],                    'safe'],
            [['links', 'expanded_ips', 'ip_normalized'],          'safe'],
            [['is_single'],                                       'boolean'],
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
}
