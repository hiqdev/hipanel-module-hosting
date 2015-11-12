<?php

namespace hipanel\modules\hosting\models;

use Yii;

class Backup extends \hipanel\base\Model
{

    use \hipanel\base\ModelTrait;

    /** @inheritdoc */
    public function rules()
    {
        return [
            [['id', 'service_id', 'object_id', 'server_id', 'account_id', 'client_id', 'ty_id', 'state_id'], 'integer'],
            [['time'], 'date'],
            [['size'], 'integer'],
            [['title', 'db_like', 'size_gb', 'time', 'domain_like', 'service', 'client', 'method', 'server', 'account', 'client', 'classes', 'name', 'ty', 'state', 'object'], 'safe'],
            [['method_label', 'type_label', 'state_label'], 'safe'],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'id' => Yii::t('app', 'Object ID'),
            'ty_id' => Yii::t('app', 'Type ID'),
            'ty' => Yii::t('app', 'Type'),
            'size_gb' => Yii::t('app', 'Size in GB'),
            'method_label' => Yii::t('app', 'Method label'),
            'object_id' => Yii::t('app', 'Backup ID'),
        ]);
    }
}
