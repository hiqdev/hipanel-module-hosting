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
use hipanel\modules\hosting\models\query\PrefixQuery;
use Yii;

class Prefix extends Model
{
    use ModelTrait;

    /** {@inheritdoc} */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['id', 'client_id', 'seller_id'], 'integer'],
            [['note', 'vrf', 'role', 'site', 'state', 'type', 'client', 'seller', 'vlan_group', 'vlan'], 'string'],
            [['ip'], 'ip', 'subnet' => null],

            [['ip', 'vrf', 'state'], 'required', 'on' => ['create', 'update']],
        ]);
    }

    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'ip' => Yii::t('hipanel.hosting.ipam', 'Prefix'),
            'vrf' => Yii::t('hipanel.hosting.ipam', 'VRF'),
            'site' => Yii::t('hipanel.hosting.ipam', 'Site'),
            'note' => Yii::t('hipanel.hosting.ipam', 'Description'),
            'vlan' => Yii::t('hipanel.hosting.ipam', 'VLAN'),
            'vlan_group' => Yii::t('hipanel.hosting.ipam', 'VLAN group'),
        ]);
    }

    /**
     * {@inheritdoc}
     * @return PrefixQuery
     */
    public static function find(array $options = []): PrefixQuery
    {
        return new PrefixQuery(get_called_class(), [
            'options' => $options,
        ]);
    }
}
