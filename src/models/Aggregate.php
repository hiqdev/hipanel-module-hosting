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
use hipanel\modules\hosting\models\query\AggregateQuery;
use hipanel\modules\hosting\models\traits\IPBlockTrait;
use Yii;
use yii\db\QueryInterface;

class Aggregate extends Model
{
    use ModelTrait, IPBlockTrait;

    /** {@inheritdoc} */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['id', 'client_id', 'seller_id', 'utilization'], 'integer'],
            [['note', 'rir', 'state', 'type', 'client', 'seller'], 'string'],
            [['ip'], 'ip', 'subnet' => true],

            [['ip', 'rir'], 'required', 'on' => ['create', 'update']],
            [['id'], 'required', 'on' => ['update']],
            [['id', 'note'], 'required', 'on' => ['set-note']],
        ]);
    }

    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'ip' => Yii::t('hipanel.hosting.ipam', 'Aggregate'),
            'rir' => Yii::t('hipanel.hosting.ipam', 'RIR'),
            'note' => Yii::t('hipanel.hosting.ipam', 'Description'),
        ]);
    }

    /**
     * {@inheritdoc}
     * @return QueryInterface
     */
    public static function find(array $options = []): QueryInterface
    {
        return new AggregateQuery(get_called_class(), [
            'options' => $options,
        ]);
    }
}
