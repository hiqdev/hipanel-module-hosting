<?php

declare(strict_types=1);

namespace hipanel\modules\hosting\models;

use Yii;
use yii\base\Model;

/**
 * Form of copying accounts with their domains, crons and DBs from one server to another.
 */
class AccountCopyForm extends Model
{
    public $old_server;
    public $new_server;
    public $is_dedicated = false;
    public $old_accounts;
    public $old_client;
    public $new_client;
    public $copy_accounts = true;
    public $copy_domains = true;
    public $copy_backuping = false;
    public $disable_dns = true;
    public $copy_crontab = false;
    public $copy_dbs = false;
    public $move_mails = false;

    public function rules(): array
    {
        return [
            [['old_server', 'new_server', 'new_client'], 'required'],
            [['old_server', 'new_server', 'old_client', 'new_client', 'old_accounts'], 'trim'],
            [['old_server', 'new_server', 'old_client', 'new_client', 'old_accounts'], 'string'],
            ['new_server', 'compare', 'compareAttribute' => 'old_server', 'operator' => '!='],
            [
                [
                    'is_dedicated', 'copy_accounts', 'copy_domains', 'copy_backuping',
                    'disable_dns', 'copy_crontab', 'copy_dbs', 'move_mails',
                ],
                'boolean',
            ],
            [
                'move_mails',
                'compare',
                'compareValue' => false,
                'when' => fn (self $model): bool => !$model->copy_domains,
                'whenClient' => "function () { return !$('#accountcopyform-copy_domains').is(':checked'); }",
                'message' => Yii::t('hipanel:hosting:account', 'Mails can be moved only together with domains'),
            ],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'old_server' => Yii::t('hipanel:hosting:account', 'Old server'),
            'new_server' => Yii::t('hipanel:hosting:account', 'New server'),
            'is_dedicated' => Yii::t('hipanel:hosting:account', 'New server is dedicated'),
            'old_accounts' => Yii::t('hipanel:hosting:account', 'Accounts'),
            'old_client' => Yii::t('hipanel:hosting:account', 'Old client'),
            'new_client' => Yii::t('hipanel:hosting:account', 'New client'),
            'copy_accounts' => Yii::t('hipanel:hosting:account', 'Copy accounts'),
            'copy_domains' => Yii::t('hipanel:hosting:account', 'Copy domains'),
            'copy_backuping' => Yii::t('hipanel:hosting:account', 'Copy domains backup settings'),
            'disable_dns' => Yii::t('hipanel:hosting:account', 'Disable DNS for new domains'),
            'copy_crontab' => Yii::t('hipanel:hosting:account', 'Copy crons'),
            'copy_dbs' => Yii::t('hipanel:hosting:account', 'Copy DBs'),
            'move_mails' => Yii::t('hipanel:hosting:account', 'Move mails'),
        ];
    }

    public function attributeHints(): array
    {
        return [
            'is_dedicated' => Yii::t('hipanel:hosting:account', 'Otherwise the new server is a VDS and only IPs sold to the accounts are used'),
            'old_accounts' => Yii::t('hipanel:hosting:account', 'Logins separated by commas or spaces; all accounts of the old server when empty'),
        ];
    }

    /**
     * Data for the API command.
     */
    public function toApi(): array
    {
        $data = $this->getAttributes();
        $data['old_accounts'] = preg_split('/[\s,;]+/', (string)$this->old_accounts, -1, PREG_SPLIT_NO_EMPTY);
        foreach ($data as $name => $value) {
            if ($value === '' || $value === null || $value === []) {
                unset($data[$name]);
            } elseif (is_bool($value) || in_array($value, ['0', '1'], true)) {
                $data[$name] = (bool)$value;
            }
        }

        return $data;
    }
}
