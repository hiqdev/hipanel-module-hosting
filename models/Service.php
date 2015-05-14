<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\models;

use Yii;

class Service extends \hipanel\base\Model
{

    use \hipanel\base\ModelTrait;

    /**
     * @inheritdoc
     */
    public function rules ()
    {
        return [

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels ()
    {
        return $this->mergeAttributeLabels([
            'remoteid'              => Yii::t('app', 'Remote ID'),
        ]);
    }
}
