<?php

namespace hipanel\modules\hosting\models;

use hipanel\base\ModelTrait;
use hipanel\modules\hosting\models\query\AddressQuery;
use Yii;
use yii\db\QueryInterface;

class Address extends Prefix
{
    use ModelTrait;

    public static function tableName()
    {
        return 'prefix';
    }

    /** {@inheritdoc} */
    public function rules()
    {
        return parent::rules();
    }

    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'ip' => Yii::t('hipanel.hosting.ipam', 'Address'),
            'type' => Yii::t('hipanel.hosting.ipam', 'Status'),
        ]);
    }

    /**
     * {@inheritdoc}
     * @return QueryInterface
     */
    public static function find(array $options = []): QueryInterface
    {
        return new AddressQuery(get_called_class(), [
            'options' => $options,
        ]);
    }
}
