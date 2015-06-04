<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\models;

use Yii;

class Hdomain extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    /** @inheritdoc */
    public function rules () {
        return [
            [
                ['id', 'server_id', 'client_id', 'seller_id', 'account_id', 'hdomain_id', 'state_id', 'type_id', 'vhost_id', 'device_id'],
                'integer'
            ],
            [['server', 'vhost', 'device', 'client', 'seller', 'account', 'domain', 'state', 'type', 'ip', 'alias'], 'safe'],
        ];
    }

    function getIsProxied() {
        return isset($this->vhost['backend']);
    }

    /** @inheritdoc */
    public function attributeLabels () {
        return $this->mergeAttributeLabels([
            'domain'               => Yii::t('app', 'Domain Name'),
        ]);
    }
}
