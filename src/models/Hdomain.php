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
use hipanel\validators\IpValidator;
use Yii;
use yii\web\JsExpression;

class Hdomain extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    /**
     * @var array Stores array of additional info for vhost of hdomain
     */
    public $vhost;

    /**
     * @var array Stores array of aliases of hdomain
     */
    public $aliases;

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
                    'device_id',
                    'dns_hdomain_id',
                ],
                'integer'
            ],
            [
                [
                    'server',
                    'device',
                    'state',
                    'type',
                    'backuping_type',
                    'state_label',
                    'alias_type',
                ],
                'safe'
            ],
            [['client', 'seller'], ClientLoginValidator::className()],
            [['account'], AccountLoginValidator::className()],
            [['dns_on', 'with_www', 'proxy_enable'], 'boolean'],
            [['domain', 'alias'], DomainValidator::className()],
            [['ip', 'backend_ip'], IpValidator::className()], /// TODO: replace with IP validator
            [['domain', 'id'], 'safe', 'on' => ['enable-paid-feature-autorenewal', 'disable-paid-feature-autorenewal']],
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
                'on' => ['create']
            ],
            [
                ['subdomain'],
                'match',
                'pattern' => '/^(\*|[a-z0-9][a-z0-9-]*)$/i',
                'message' => \Yii::t('app', '{attribute} does not look like a domain part'),
                'on' => ['create-alias']
            ],
            [
                [
                    'server',
                    'account',
                    'vhost_id',
                    'with_www',
                ],
                'required',
                'on' => ['create-alias']
            ],
            [
                [
                    'domain',
                ],
                'required',
                'when' => function ($model) {
                    return $model->alias_type === 'new';
                },
                'whenClient' => new JsExpression("function (attribute, value) {
                    return false;
                }"),
                'on' => ['create-alias']
            ],
            [
                ['id'],
                'required',
                'on' => ['delete']
            ]
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
            'domain' => Yii::t('app', 'Domain Name'),
            'backend_ip' => Yii::t('app', 'Backend IP'),
            'with_www' => Yii::t('app', 'Create www alias'),
            'proxy_enable' => Yii::t('app', 'Enable proxy (NEED MANUAL)'),
            'backuping_type' => Yii::t('app', 'Backup periodicity'),
            'dns_on' => Yii::t('app', 'DNS'),
            'vhost_id' => Yii::t('app', 'Alias for')
        ]);
    }

    public function scenarioCommands()
    {
        $result = [];

        if (in_array($this->scenario, ['create', 'update'])) {
            $result['create'] = ['vhosts', ucfirst($this->scenario)]; // Create should be send to vhost module
        }
        $result['create-alias'] = 'create';
        return $result;
    }
}
