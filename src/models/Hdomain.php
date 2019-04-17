<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\models;

use hipanel\modules\client\validators\LoginValidator as ClientLoginValidator;
use hipanel\modules\hosting\validators\LoginValidator as AccountLoginValidator;
use hipanel\validators\DomainValidator;
use Yii;
use yii\web\JsExpression;

class Hdomain extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    const STATE_OK = 'ok';
    const STATE_BLOCKED = 'blocked';
    const STATE_DELETED = 'deleted';
    const STATE_DISABLED = 'disabled';
    const STATE_TEMPORARY = 'temporary';

    public function init()
    {
        $this->on(self::EVENT_AFTER_FIND, function ($event) {
            $this->setAttributes([
                'ip' => $this->getAttribute('vhost')['ip'],
                'backend_ip' => $this->getAttribute('vhost')['backend']['ip'],
                'proxy_enabled' => $this->getIsProxied(),
            ]);
        });
    }

    /**
     * @var array Stores array of additional info for vhost of hdomain
     */
    public $vhost;

    /**
     * @var array Stores array of aliases of hdomain
     */
    public $aliases;

    /** {@inheritdoc} */
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
                'integer',
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
                    'proxy_enabled',
                    'dns_hdomain_domain',
                ],
                'safe',
            ],
            [['client', 'seller'], ClientLoginValidator::class],
            [['account'], AccountLoginValidator::class],
            [['with_www'], 'boolean', 'on' => ['create-alias']],
            [['dns_on', 'with_www', 'proxy_enable'], 'boolean', 'on' => ['create']],
            [['domain', 'alias'], DomainValidator::class],
            [['ip', 'backend_ip'], 'ip'],
            [['ip'], 'required', 'on' => ['create']],
            [['domain', 'id'], 'safe', 'on' => ['enable-paid-feature-autorenewal', 'disable-paid-feature-autorenewal']],
            [
                [
                    'server',
                    'account',
                    'domain',
                    'path',
                    'ip',
                ],
                'required',
                'on' => ['create'],
            ],
            [
                ['subdomain'],
                'match',
                'pattern' => '/^(\*|[a-z0-9][a-z0-9-]*)$/i',
                'message' => Yii::t('hipanel', '{attribute} does not look like a domain part'),
                'on' => ['create-alias'],
            ],
            [
                [
                    'server',
                    'account',
                    'vhost_id',
                ],
                'required',
                'on' => ['create-alias'],
            ],
            [
                [
                    'domain',
                ],
                'required',
                'when' => function ($model) {
                    return $model->alias_type === 'new';
                },
                'whenClient' => new JsExpression('function (attribute, value) {
                    return false;
                }'),
                'on' => ['create-alias'],
            ],
            [
                ['id'],
                'required',
                'on' => ['manage-proxy', 'enable-backuping', 'disable-backuping', 'delete'],
            ],
            [['type', 'comment'], 'required', 'on' => ['enable-block']],
            [['comment'], 'safe', 'on' => ['disable-block']],
            [['id', 'dns_on'], 'safe', 'on' => ['set-dns-on']],
            [['backuping_exists'], 'boolean'],
            [['backuping_type'], 'required', 'on' => ['enable-backuping', 'disable-backuping']],
            [['id', 'premium_autorenewal'], 'required', 'on' => ['set-paid-feature-autorenewal']],
        ];
    }

    public function getIsProxied()
    {
        return isset($this->getAttribute('vhost')['backend']);
    }

    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'backend_ip'        => Yii::t('hipanel:hosting', 'Backend IP'),
            'with_www'          => Yii::t('hipanel:hosting', 'Create www alias'),
            'proxy_enable'      => Yii::t('hipanel:hosting', 'Enable proxy'),
            'backuping_type'    => Yii::t('hipanel:hosting', 'Backup periodicity'),
            'vhost_id'          => Yii::t('hipanel:hosting', 'Alias for'),
            'proxy_enabled'     => Yii::t('hipanel:hosting', 'Proxy enabled'),
            'path'              => Yii::t('hipanel:hosting', 'Path'),
            'dns_on'            => Yii::t('hipanel', 'DNS'),
            'comment'           => Yii::t('hipanel', 'Comment'),
        ]);
    }

    public function getIsBlocked()
    {
        return $this->state === static::STATE_BLOCKED;
    }

    public function getDnsId()
    {
        return $this->dns_hdomain_id ?: $this->id;
    }

    public function isAlias()
    {
        return isset($this->vhost_id);
    }

    /** {@inheritdoc} */
    public function scenarioActions()
    {
        return [
            'create'            => [Vhost::tableName(), 'create'], // Create must be sent to Vhost module
            'create-alias'      => 'create',
            'set-dns-on'        => 'update',
            'enable-backuping'  => 'update-backuping',
            'disable-backuping' => 'update-backuping',
        ];
    }
}
