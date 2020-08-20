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
use Yii;

class Aggregate extends Model
{
    use ModelTrait;

    /** {@inheritdoc} */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['id', 'client_id', 'seller_id'], 'integer'],
            [['note', 'rir', 'state', 'type', 'client', 'seller'], 'string'],
            [['ip'], 'ip', 'subnet' => null],

            [['ip', 'rir'], 'required', 'on' => ['create', 'update']],
            [['id'], 'required', 'on' => ['update']],
        ]);
    }

    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'ip' => Yii::t('hipanel.hosting.ipam', 'Prefix'),
            'rir' => Yii::t('hipanel.hosting.ipam', 'RIR'),
            'note' => Yii::t('hipanel.hosting.ipam', 'Description'),
        ]);
    }
}
