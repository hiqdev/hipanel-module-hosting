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
            [['id', 'service_id', 'object_id', 'server_id', 'account_id', 'client_id', 'state_id'], 'integer'],
            [['time'], 'date'],
            [['size'], 'integer'],
            [
                [
                    'title', 'size_gb', 'time', 'service',
                    'client', 'method', 'server', 'account',
                    'client', 'object', 'name', 'state', 'type'
                ],
                'safe'
            ],
            [['method_label', 'type_label', 'state_label'], 'safe'],
            [['id'], 'integer', 'on' => ['delete']],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'id' => Yii::t('app', 'Object ID'),
            'method_label' => Yii::t('app', 'Method label'),
            'object_id' => Yii::t('app', 'Backup ID'),
            'size' => Yii::t('hipanel/hosting', 'Size'),
        ]);
    }
}
