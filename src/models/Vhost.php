<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\models;

use hipanel\helpers\StringHelper;
use hipanel\modules\client\validators\LoginValidator;
use hipanel\validators\IpValidator;
use Yii;

class Vhost extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    public $backend;

    public function init() {
        $this->on(self::EVENT_AFTER_FIND, function ($event) {
            $this->setAttributes([
                'backend_ip' => $this->getAttribute('backend')['ip'],
                'proxy_enabled' => $this->getIsProxied(),
            ]);
        });
    }

    public function rules()
    {
        return [
            [
                [
                    'domain',
                    'ip',
                    'port',
                    'path',
                    'client',
                    'device',
                    'account',
                    'service',
                    'server',
                    'soft',
                    'type',
                    'state',
                    'state_label',
                    'backuping_type',
                    'backuping_type_label',
                    'cgibin_postfix',
                    'domain_prefix',
                    'docroot_postfix',
                    'apache_conf',
                    'nginx_conf',
                    'docroot',
                    'cgibin',
                    'fullpath',
                    'proxy_enabled',
                ],
                'safe'
            ],
            [
                [
                    'id',
                    'ip_id',
                    'frontend_id',
                    'client_id',
                    'device_id',
                    'server_id',
                    'account_id',
                    'soft_id',
                    'service_id',
                ],
                'integer'
            ],
            [
                [
                    'enable_ssi',
                    'enable_suexec',
                    'enable_accesslog',
                    'enable_errorslog',
                    'enable_scripts',
                    'dns_on',
                ],
                'boolean'
            ],
            [
                ['id'],
                'required',
                'on' => ['advanced-config', 'manage-proxy']
            ],
            [['ip', 'backend_ip'], IpValidator::className()], /// TODO: replace with core IP validator
            [['ip'], 'required', 'on' => ['manage-proxy']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'domain_prefix' => Yii::t('app', 'Domain directory prefix'),
            'docroot_postfix' => Yii::t('app', 'DocumentRoot directory postfix'),
            'cgibin' => Yii::t('app', 'CGI-BIN directory postfix'),
            'nginx_conf' => Yii::t('app', 'Additional NGINX config'),
            'apache_conf' => Yii::t('app', 'Additional Apache config'),
            'enable_accesslog' => Yii::t('app', 'Enable access log'),
            'enable_errorslog' => Yii::t('app', 'Enable error log'),
            'enable_suexec' => Yii::t('app', 'Enable suexec'),
            'enable_scripts' => Yii::t('app', 'Allow scripts execution'),
            'enable_ssi' => Yii::t('app', 'Enable SSI'),
        ]);
    }

    public function getIsProxied()
    {
        return isset($this->getAttribute('backend')['id']);
    }

    public function getBackend_ip()
    {
        return $this->getAttribute('backend')['ip'];
    }

    public function scenarioCommands()
    {
        return [
            'advanced-config' => 'setAdvancedConfig',
        ];
    }
}
