<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\models;

use hipanel\helpers\ArrayHelper;
use hipanel\modules\client\validators\LoginValidator;
use hipanel\validators\IpValidator;
use Yii;

class Account extends \hipanel\base\Model
{

    use \hipanel\base\ModelTrait;

    public function init()
    {
        $this->on(static::EVENT_BEFORE_INSERT, [$this, 'onBeforeInsert']);
    }

    public function rules()
    {
        return [
            [['id', 'client_id', 'device_id', 'server_id'], 'integer'],
            [
                ['login', 'password', 'uid', 'gid', 'shell', 'client', 'path', 'home', 'device', 'server', 'seller', 'seller_id'],
                'safe'
            ],
            [['type', 'type_label', 'state', 'state_label'], 'safe'],
            [['ip', 'allowed_ips', 'objects_count', 'request_state', 'request_state_label', 'mail_settings'], 'safe'],
            [
                [
                    'login',
                    'server_id',
                    'password',
                    'sshftp_ips',
                    'type',
                ],
                'safe',
                'on' => ['create-user', 'create-ftponly']
            ],
            [
                [
                    'login',
                    'server_id',
                    'password',
                    'sshftp_ips',
                    'type',
                ],
                'required',
                'on' => ['create-user', 'create-ftponly']
            ],
            [
                ['password'],
                'required',
                'on' => ['set-password']
            ],
            [
                'password',
                'compare',
                'compareAttribute' => 'login',
                'message'          => Yii::t('app', 'Password must not be equal to login'),
                'operator'         => '!=',
                'on'               => ['create-user', 'create-ftponly', 'update', 'set-password'],
            ],
            [
                'login',
                LoginValidator::className(),
                'on' => ['create-user', 'create-ftponly', 'set-password']
            ],
            [
                'login',
                'in',
                'range'   => ['root', 'toor'],
                'not'     => true,
                'on'      => ['create-user', 'create-ftponly'],
                'message' => Yii::t('app', 'You can not use this login')
            ],
            [
                'sshftp_ips',
                'filter',
                'filter' => function ($value) { return ArrayHelper::csplit($value); },
                'on'     => ['create-user', 'create-ftponly', 'update', 'set-allowed-ips']
            ],
            [
                'sshftp_ips',
                'each',
                'rule' => [IpValidator::className(), 'negationChar' => true, 'subnet' => null],
                'on'   => ['create-user', 'create-ftponly', 'update', 'set-allowed-ips']
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'login_like'  => Yii::t('app', 'Login'),
            'type_label'  => Yii::t('app', 'state'),
            'state_label' => Yii::t('app', 'state'),
            'allowed_ips' => Yii::t('app', 'Allowed IPs'),
            'sshftp_ips'  => Yii::t('app', 'IP to access on the server via SSH or FTP'),
            'server_id'   => Yii::t('app', 'Server'),
        ]);
    }

    public function goodStates()
    {
        return ['ok'];
    }

    /**
     * @return bool
     */
    public function isOperable()
    {
        /// TODO: all is operable for admin
        if (!in_array($this->state, $this->goodStates())) {
            return false;
        }

        return true;
    }

    public function getSshFtpIpsList()
    {
        return implode(', ', $this->sshftp_ips);
    }

    public function getKnownTypes()
    {
        return ['user', 'ftponly'];
    }

    public function scenarioCommands()
    {
        return [
            'set-allowed-ips' => [null, 'SetAllowedIPs'],
            'create-user'     => 'create',
            'create-ftponly'  => 'create',
        ];
    }

    public function onBeforeInsert()
    {
        if ($this->scenario == 'create-user') {
            $this->type = 'user';
        } elseif ($this->scenario == 'create-ftponly') {
            $this->type = 'ftponly';
        }
        return true;
    }
}
