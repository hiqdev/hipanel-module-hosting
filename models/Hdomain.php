<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\models;

use hipanel\modules\client\validators\LoginValidator as ClientLoginValidator;
use hipanel\modules\domain\validators\DomainValidator;
use hipanel\modules\hosting\validators\LoginValidator as AccountLoginValidator;
use Yii;

class Hdomain extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    /**
     * @var array Stores array of additional info for vhost of hdomain
     */
    public $vhost;

    /** @inheritdoc */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'server_id',
                    'client_id',
                    'seller_id',
                    'account_id',
                    'hdomain_id',
                    'state_id',
                    'type_id',
                    'vhost_id',
                    'device_id'
                ],
                'integer'
            ],
            [
                [
                    'server',
                    'device',
                    'state',
                    'type',
                    'backuping_type'
                ],
                'safe'
            ],
            [
                [
                    'server',
                    'account',
                    'domain',
                    'with_www',
                    'path',
                    'ip',
                ],
                'required',
                'on' => 'create'
            ],
            [['client','seller'], ClientLoginValidator::className()],
            [['account'], AccountLoginValidator::className()],
            [['dns_on', 'with_www', 'proxy_enable'], 'boolean'],
            [['domain', 'alias'], DomainValidator::className()],
            [['ip', 'backend_ip'], 'safe'], /// TODO: replace with IP validator
        ];
    }

    function getIsProxied()
    {
        return isset($this->vhost['backend']);
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'domain'         => Yii::t('app', 'Domain Name'),
            'backend_ip'     => Yii::t('app', 'Backend IP'),
            'with_www'       => Yii::t('app', 'Create www alias'),
            'proxy_enable'   => Yii::t('app', 'Enable proxy (NEED MANUAL)'),
            'backuping_type' => Yii::t('app', 'Backup periodicity'),
        ]);
    }

    public function scenarioCommands()
    {
        $result = [];

        if (in_array($this->scenario, ['create', 'update'])) {
            $result['create'] = ['vhosts', ucfirst($this->scenario)]; // Create should be send to vhost module
        }
        return $result;
    }
}
