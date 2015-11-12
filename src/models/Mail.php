<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\models;

use Yii;

class Mail extends \hipanel\base\Model
{

    use \hipanel\base\ModelTrait;

    /** @inheritdoc */
    public function rules()
    {
        return [
            [['id', 'hdomain_id', 'client_id', 'seller_id', 'account_id', 'server_id'], 'integer'],
            [['mail', 'nick', 'hdomain', 'client', 'seller', 'account', 'server', 'domain'], 'safe'],
            [['type', 'state', 'state_label', 'password', 'spam_forward_mail'], 'safe'],
            [['forwards', 'spam_action', 'autoanswer', 'du_limit'], 'safe'],
            [['is_alias'], 'boolean'],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'hdomain' => Yii::t('app', 'Domain Name'),
            'domain' => Yii::t('app', 'Domain Name'),
            'forwards' => Yii::t('app', 'Forwarding'),
            'du_limit' => Yii::t('app', 'Disk usage limit'),
            'mail' => Yii::t('app', 'E-mail'),
            'mail_like' => Yii::t('app', 'E-mail'),
        ]);
    }
}
