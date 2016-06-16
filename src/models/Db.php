<?php

/*
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\models;

use hipanel\base\Model;
use hipanel\base\ModelTrait;
use hipanel\modules\hosting\validators\DbNameValidator;
use Yii;

class Db extends Model
{
    use ModelTrait;

    /** @inheritdoc */
    public function rules()
    {
        return [
            [['id', 'account_id', 'client_id', 'seller_id', 'service_id', 'device_id', 'server_id'], 'integer'],
            [['name', 'account', 'client', 'seller', 'service', 'device', 'server'], 'safe'],
            [['service_ip', 'description'], 'safe'],
            [['type', 'state', 'backuping_type', 'type_label', 'state_label', 'backuping_type_label'], 'safe'],
            /// Create
            [['server', 'account', 'service_id', 'name', 'password'], 'required', 'on' => ['create']],
            [['name'], DbNameValidator::className(), 'on' => ['create']],
            [
                ['password'],
                'match',
                'pattern' => '/^[\x20-\x7f]*$/',
                'message' => \Yii::t('app', '{attribute} should not contain non-latin characters'),
                'on'      => ['create', 'set-password']
            ],
            [['password'], 'required', 'on' => ['set-password']],
            [['id'], 'required', 'on' => ['delete', 'set-password', 'set-description', 'truncate']]
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'name'                 => Yii::t('app', 'DB name'),
            'service_ip'           => Yii::t('app', 'Service IP'),
            'backuping_type'       => Yii::t('app', 'Type of backuping'),
            'backuping_type_label' => Yii::t('app', 'Backuping type label'),
        ]);
    }
}
