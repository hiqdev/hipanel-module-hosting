<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\models;

use Yii;

class Backuping extends \hipanel\base\Model
{

    use \hipanel\base\ModelTrait;

    /** @inheritdoc */
    public function rules()
    {
        return [
            [['id', 'service_id', 'server_id', 'account_id', 'client_id'], 'integer'],
            [['skip_lock'], 'boolean'],
            [['day', 'hour', 'path', 'include', 'exclude'], 'safe'],
            [['method', 'method_label', 'server', 'account', 'client', 'name', 'object', 'service'], 'safe'],
            [['backup_last'], 'date'],
            [['backup_count', 'total_du', 'total_du_gb',], 'integer'],
            [['type', 'type_label', 'state', 'state_label'], 'safe'],

            [['id', 'type'], 'safe', 'on' => ['update']],
            [['id'], 'integer', 'on' => ['delete', 'disable', 'enable']],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'day' => Yii::t('app', 'Date'),
            'hour' => Yii::t('app', 'Time'),
            'backup_last' => Yii::t('hipanel/hosting', 'Last backup'),
            'backup_count' => Yii::t('app', 'Count'),
            'total_du' => Yii::t('hipanel/hosting', 'Disk usage'),
            'total_du_gb' => Yii::t('app', 'Disk'),
            'method_label' => Yii::t('app', 'Method label'),
            'account_id' => Yii::t('app', 'Account'),
            'server_id' => Yii::t('app', 'Server'),
            'state_label' => Yii::t('app', 'State'),
            'state' => Yii::t('app', 'State'),
            'type' => Yii::t('hipanel/hosting', 'Periodicity'),
            'object' => Yii::t('hipanel/hosting', 'Object'),
        ]);
    }
}
