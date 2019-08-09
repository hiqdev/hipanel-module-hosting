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

use hipanel\base\Model;
use hipanel\base\ModelTrait;
use hipanel\modules\hosting\validators\DbNameValidator;
use Yii;

class Db extends Model
{
    use ModelTrait;

    /** {@inheritdoc} */
    public function rules()
    {
        return [
            [['id', 'account_id', 'client_id', 'seller_id', 'service_id', 'device_id', 'server_id'], 'integer'],
            [['name', 'account', 'client', 'seller', 'service', 'device', 'server'], 'safe'],
            [['service_ip', 'description'], 'safe'],
            [['type', 'state', 'backuping_type', 'type_label', 'state_label', 'backuping_type_label'], 'safe'],
            /// Create
            [['server', 'account', 'service_id', 'name', 'password'], 'required', 'on' => ['create']],
            [['name'], DbNameValidator::class, 'on' => ['create']],
            [['password'], 'string', 'min' => 8, 'max' => 20, 'on' => ['create', 'set-password']],
            [
                ['password'],
                'match',
                'pattern' => '/^([A-Za-z0-9!@#$%^&*()\-_=+{};:,<.>]{8,20})$/', // old version '/^[\x20-\x7f]*$/'
                'message' => Yii::t('hipanel:hosting', '{attribute} should not contain non-latin characters'),
                'on'      => ['create', 'set-password'],
            ],
            [
                ['password'],
                'match',
                'pattern' => '/(?=(?:.*[!@#$%^&*()\-_=+{};:,<.>]){1,})/',
                'message' => Yii::t('hipanel:hosting', '{attribute} should contain at least one special character'),
                'on' => ['create', 'set-password'],
            ],
            [['password'], 'required', 'on' => ['set-password']],
            [['id'], 'required', 'on' => ['delete', 'set-password', 'set-description', 'truncate']],
            [['backuping_exists'], 'boolean'],
            [['backuping_type'], 'required', 'on' => ['enable-backuping', 'disable-backuping']],
        ];
    }

    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'name'                 => Yii::t('hipanel:hosting', 'DB name'),
            'service_ip'           => Yii::t('hipanel:hosting', 'Service IP'),
            'backuping_type'       => Yii::t('hipanel:hosting', 'Backup type'),
        ]);
    }

    public function scenarioActions()
    {
        $result = [];
        $result['enable-backuping'] = 'update-backuping';
        $result['disable-backuping'] = 'update-backuping';

        return $result;
    }
}
