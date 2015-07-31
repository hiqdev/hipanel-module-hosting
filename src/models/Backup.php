<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\models;

use Yii;

class Backup extends \hipanel\base\Model
{

    use \hipanel\base\ModelTrait;

    /** @inheritdoc */
    public function rules () {
        return [
            [['id', 'service_id','object_id', 'server_id','account_id', 'client_id', 'ty_id', 'state_id'],  'integer'],
            [['time'],                                                                                      'date'],
            [['size', 'size_gb'],                                                                           'integer'],
            [['service', 'method', 'server', 'account', 'client', 'name', 'ty', 'state'],                   'safe'],
            [['method_label', 'type_label', 'state_label'],                                                 'safe'],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels () {
        return $this->mergeAttributeLabels([
            'object_id'             => Yii::t('app', 'Object ID'),
            'ty_id'                 => Yii::t('app', 'Type ID'),
            'ty'                    => Yii::t('app', 'Type'),
            'size_gb'               => Yii::t('app', 'Size in GB'),
            'method_label'          => Yii::t('app', 'Method label'),
        ]);
    }
}
