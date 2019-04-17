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

use hipanel\models\Obj;
use Yii;

class Backup extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    /** {@inheritdoc} */
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
                    'client', 'object', 'name', 'state', 'type',
                ],
                'safe',
            ],
            [['method_label', 'type_label', 'state_label'], 'safe'],
            [['id'], 'integer', 'on' => ['delete']],
        ];
    }

    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'method'    => Yii::t('hipanel:hosting', 'Method'),
            'size'      => Yii::t('hipanel:hosting', 'Size'),
        ]);
    }

    public function getObj()
    {
        return Yii::createObject([
            'class' => Obj::class,
            'id' => $this->object_id,
            'name' => $this->name,
            'class_name' => $this->object,
        ]);
    }
}
