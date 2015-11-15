<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\models;

use hipanel\modules\hosting\validators\EmailLocalPartValidator;
use Yii;
use yii\helpers\StringHelper;

class Mail extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    const TYPE_FORWARD_ONLY = 'forward_only';
    const TYPE_BOX_WITH_FORWARDS = 'mailbox_with_forwards';
    const TYPE_MAILBOX = 'mailbox';

    const SPAM_ACTION_NONE = '';
    const SPAM_ACTION_DELETE = 'delete';

    /** @inheritdoc */
    public function rules()
    {
        return [
            [['id', 'client_id', 'seller_id', 'account_id', 'server_id'], 'integer'],
            [['mail', 'nick', 'hdomain', 'client', 'seller', 'account', 'server', 'domain'], 'safe'],
            [['type', 'state', 'state_label', 'password', 'spam_forward_mail'], 'safe'],
            [['is_alias'], 'boolean'],
            [['hdomain_id'], 'integer', 'on' => ['create']],
            [['server', 'account'], 'safe', 'on' => ['create']],
            [['password'], 'safe', 'on' => ['create']],
            [['password'], 'safe', 'on' => ['update', 'set-password'], 'when' => function ($model) {
                return !$model->canChangePassword();
            }],
            [['nick'], EmailLocalPartValidator::className(), 'on' => ['create']],
            [['forwards', 'spam_forward_mail'], 'filter', 'filter' => function ($value) {
                $res = StringHelper::explode($value, ',', true, true);
                return $res;
            }, 'skipOnArray' => true, 'on' => ['create', 'update']],
            [['forwards', 'spam_forward_mail'], 'each', 'rule' => ['email'], 'on' => ['create', 'update']],
            [['spam_action', 'autoanswer', 'du_limit'], 'safe', 'on' => ['create', 'update']],
            [['id'], 'required', 'on' => ['update', 'delete']],
            [['hdomain_id', 'server', 'account', 'nick'], 'required', 'on' => ['create']],
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
            'autoanswer' => Yii::t('app', 'Auto answer'),
            'hdomain_id' => Yii::t('app', 'Domain'),
        ]);
    }

    public function canChangePassword() {
        return $this->type !== static::TYPE_FORWARD_ONLY;
    }

    public function attributeHints() {
        return [
            'forwards' => Yii::t('app', 'All messages will be forwarded on the specified addresses. You can select email from the list of existing or wright down your own.'),
            'password' => $this->type === static::TYPE_FORWARD_ONLY
                            ?  Yii::t('app', 'Password change is prohibited on forward-only mailboxes')
                            : ( $this->isNewRecord
                                ? Yii::t('app', 'Leave this field empty to create a forward-only mailbox')
                                : Yii::t('app', 'Fill this field only if you want to change the password')
                            ),
        ];
    }
}
