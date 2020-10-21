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
use hipanel\models\Ref;
use hipanel\modules\hosting\models\query\PrefixQuery;
use hipanel\modules\hosting\models\traits\IPBlockTrait;
use Yii;
use yii\db\QueryInterface;

class Prefix extends Model
{
    use ModelTrait, IPBlockTrait;

    /** {@inheritdoc} */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['id', 'parent_id', 'client_id', 'seller_id', 'utilization', 'aggregate_id', 'ip_count', 'child_count'], 'integer'],
            [['note', 'vrf', 'role', 'site', 'state', 'type', 'client', 'seller', 'vlan_group', 'vlan', 'aggregate'], 'string'],
            [['parent_ip'], 'ip'],
            [['tags'], 'safe'],

            [['ip', 'vrf'], 'required', 'on' => ['create', 'update']],
            [['id', 'note'], 'required', 'on' => ['set-note']],
            [['type'], 'required', 'when' => fn() => self::class === static::class, 'on' => ['create', 'update']],
            'ip_validate' => [['ip'], 'ip', 'subnet' => true, 'on' => ['create', 'update']],
        ]);
    }

    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'ip' => Yii::t('hipanel.hosting.ipam', 'Prefix'),
            'type' => Yii::t('hipanel.hosting.ipam', 'Status'),
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
    public static function find(array $options = []): QueryInterface
    {
        return new PrefixQuery(get_called_class(), [
            'options' => $options,
        ]);
    }

    public function getParent(): QueryInterface
    {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    public function isSuggested(): bool
    {
        return !$this->state && !$this->client;
    }

    public function getTagOptions(): array
    {
        return Ref::getList('tag,ip', 'hipanel:hosting');
    }
}
