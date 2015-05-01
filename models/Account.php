<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\models;

use hipanel\helpers\ArrayHelper;
use hipanel\modules\client\validators\LoginValidator;
use hipanel\validators\IpAddressValidator;
use Yii;

class Account extends \hipanel\base\Model
{

    use \hipanel\base\ModelTrait;

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
                'on' => ['insert-user', 'insert-ftponly']
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
                'on' => ['insert-user', 'insert-ftponly']
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
                'on'               => ['insert-user', 'insert-ftponly', 'update', 'set-password'],
            ],
            [
                'login',
                LoginValidator::className(),
                'on' => ['insert-user', 'insert-ftponly', 'set-password']
            ],
            [
                'login',
                'in',
                'range'   => ['root', 'toor'],
                'not'     => true,
                'on'      => ['insert-user', 'insert-ftponly'],
                'message' => Yii::t('app', 'You can not use this login')
            ],
            [
                'sshftp_ips',
                'filter',
                'filter' => function ($value) { return ArrayHelper::csplit($value); },
                'on'     => ['insert-user', 'insert-ftponly', 'update']
            ],
            [
                'sshftp_ips',
                IpAddressValidator::className(),
                'on'        => ['insert-user', 'insert-ftponly', 'update', 'set-allowed-ips'],
                'exclusion' => true
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
            'insert-user'     => 'create',
            'insert-ftponly'  => 'create',
        ];
    }
}
