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

use hipanel\helpers\StringHelper;
use hipanel\modules\hosting\models\query\AccountQuery;
use hipanel\modules\hosting\validators\LoginValidator;
use Yii;

/**
 * Class Account
 * @package hipanel\modules\hosting\models
 *
 * @property $values
 */
class Account extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    public static $i18nDictionary = 'hipanel:hosting';

    const TYPE_SSH = 'user';
    const TYPE_FTP = 'ftponly';

    const STATE_OK = 'ok';
    const STATE_BLOCKED = 'blocked';
    const STATE_DELETED = 'deleted';

    public function init()
    {
        $this->on(static::EVENT_BEFORE_VALIDATE, [$this, 'onBeforeValidate']);
    }

    public function rules()
    {
        return [
            [['id', 'client_id', 'device_id', 'server_id', 'seller_id'], 'integer'],
            [
                ['login', 'password', 'shell', 'client', 'path', 'home', 'device', 'server', 'seller', 'uid', 'gid'],
                'safe',
            ],
            [['type', 'type_label', 'state', 'state_label'], 'safe'],
            [['ip', 'allowed_ips', 'objects_count', 'request_state', 'request_state_label'], 'safe'],
            [['login', 'server', 'password', 'sshftp_ips', 'type'], 'safe', 'on' => ['create', 'create-ftponly']],
            [['login', 'server', 'password', 'type'], 'required', 'on' => ['create', 'create-ftponly']],
            [['account', 'path'], 'required', 'on' => ['create-ftponly']],
            [['login'], 'required', 'on' => ['change-password']],
            [['password'], 'required', 'on' => ['change-password']],
            [
                ['password'],
                'compare',
                'compareAttribute' => 'login',
                'message' => Yii::t('hipanel', 'Password must not be equal to login'),
                'operator' => '!=',
                'on' => ['create', 'create-ftponly', 'update', 'change-password'],
            ],
            [['login'], LoginValidator::class, 'on' => ['create', 'create-ftponly', 'change-password']],
            [
                ['login'],
                'in',
                'range' => ['root', 'toor'],
                'not' => true,
                'on' => ['create', 'create-ftponly'],
                'message' => Yii::t('hipanel:hosting', 'You can not use this login'),
            ],
            [
                ['sshftp_ips'],
                'filter',
                'filter' => function ($value) {
                    return StringHelper::explode($value);
                },
                'on' => ['create', 'create-ftponly', 'update', 'set-allowed-ips'],
            ],
            [
                ['sshftp_ips'],
                'each',
                'rule' => ['ip', 'negation' => true, 'subnet' => null],
                'on' => ['create', 'create-ftponly', 'update', 'set-allowed-ips'],
            ],
            [
                ['id'],
                'required',
                'on' => ['change-password', 'set-allowed-ips', 'set-mail-settings', 'set-system-settings', 'set-ghost-options', 'delete'],
            ],
            [['id'], 'canSetMailSettings', 'on' => ['set-mail-settings']],
            [['path', 'gid', 'uid'], 'string', 'on' => ['set-system-settings']],
            [['account', 'server'], 'required', 'on' => ['get-directories-list']],
            [['type', 'comment'], 'required', 'on' => ['enable-block']],
            [['comment'], 'safe', 'on' => ['disable-block']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'allowed_ips'    => Yii::t('hipanel:hosting', 'Allowed IPs'),
            'sshftp_ips'     => Yii::t('hipanel:hosting', 'IP to access on the server via SSH or FTP'),
            'path'           => Yii::t('hipanel:hosting:account', 'Home directory'),
            'gid'            => Yii::t('hipanel:hosting:account', 'Group'),
            'uid'            => Yii::t('hipanel:hosting:account', 'ID'),
        ]);
    }

    public function goodStates()
    {
        return [self::STATE_OK];
    }

    public function getValues()
    {
        return $this->hasOne(AccountValues::class, ['id' => 'id']);
    }

    /**
     * @return bool
     */
    public function isOperable()
    {
        /// TODO: all is operable for admin
        if (!in_array($this->state, $this->goodStates(), true)) {
            return false;
        }

        return true;
    }

    public function getSshFtpIpsList()
    {
        return implode(', ', empty($this->sshftp_ips) ? ['0.0.0.0/0'] : $this->sshftp_ips);
    }

    public function getKnownTypes()
    {
        return [static::TYPE_FTP, static::TYPE_SSH];
    }

    public function getIsBlocked()
    {
        return $this->state === self::STATE_BLOCKED;
    }

    public function canSetMailSettings()
    {
        return $this->type === self::TYPE_SSH && Yii::$app->user->can('support');
    }

    public function scenarioActions()
    {
        return [
            'set-allowed-ips' => 'set-allowed-IPs',
            'create-ftponly' => 'create',
        ];
    }

    public function onBeforeValidate()
    {
        if ($this->scenario === 'create') {
            $this->type = static::TYPE_SSH;
        } elseif ($this->scenario === 'create-ftponly') {
            $this->type = static::TYPE_FTP;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     * @return AccountQuery
     */
    public static function find(array $options = []): AccountQuery
    {
        return new AccountQuery(get_called_class(), [
            'options' => $options,
        ]);
    }
}
