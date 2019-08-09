<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

/**
 * @see    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\models;

use hipanel\base\Model;
use hipanel\base\ModelTrait;
use Yii;

class Request extends Model
{
    use ModelTrait;

    /** {@inheritdoc} */
    public function rules()
    {
        return [
            [['id', 'object_id', 'service_id', 'client_id', 'account_id', 'server_id'], 'integer'],
            [['realm', 'service', 'client', 'account', 'server', 'type_ids'], 'safe'],
            [['child', 'parent', 'error_code', 'error_detailed'], 'string'],
            [['type', 'type_label', 'state', 'state_label', 'action', 'object_class', 'classes', 'class_label'], 'safe'],
            [['parent_id', 'child_id', 'tries_left', 'pid', 'time_lag'], 'integer'],
            [['object_name'], 'safe'],
            [['time', 'create_time', 'update_time'], 'date'],
            [['id'], 'integer', 'on' => ['delete']],
        ];
    }

    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'object_name' => Yii::t('hipanel:hosting', 'Object Name'),
            'object' => Yii::t('hipanel:hosting', 'Object'),
            'classes' => Yii::t('hipanel:hosting', 'Object'),
            'type_ids' => Yii::t('hipanel', 'Types'),
            'time' => Yii::t('hipanel:hosting', 'Scheduled time'),
            'pid' => Yii::t('hipanel:hosting', 'PID'),
        ]);
    }

    public function getObject(): string
    {
        return sprintf('%s %s', $this->server, empty($this->object_name) ? $this->class_label : $this->object_name);
    }
}
