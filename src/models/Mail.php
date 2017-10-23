<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
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

    /** {@inheritdoc} */
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
            [['password'], function ($attribute) {
                if (!mb_check_encoding($this->{$attribute}, 'ASCII')) {
                    $this->addError(Yii::t('hipanel:hosting', 'password can contain only latin characters and digits'));
                }
            }, 'on' => ['create', 'update', 'set-password']],
            [['password'], 'match', 'pattern' => '/^[a-zA-Z0-9]+$/',
                'message' => Yii::t('hipanel:hosting', 'Password can contain only latin characters and digits.'),
                'on' => ['create', 'update', 'set-password'], ],
            [['nick'], EmailLocalPartValidator::class, 'on' => ['create']],
            [['forwards', 'spam_forward_mail'], 'filter', 'filter' => function ($value) {
                $res = StringHelper::explode($value, ',', true, true);

                return $res;
            }, 'skipOnArray' => true, 'on' => ['create', 'update']],
            [['forwards', 'spam_forward_mail'], 'each', 'rule' => ['email'], 'on' => ['create', 'update']],
            [['spam_action', 'autoanswer'], 'safe', 'on' => ['create', 'update']],
            [['du_limit'], 'integer', 'on' => ['create', 'update']],
            [['id'], 'required', 'on' => ['update', 'delete']],
            [['hdomain_id', 'server', 'account', 'nick'], 'required', 'on' => ['create']],

            [['id'], 'integer', 'on' => ['enable', 'disable']],
        ];
    }

    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'forwards'      => Yii::t('hipanel:hosting', 'Forwarding'),
            'du_limit'      => Yii::t('hipanel:hosting', 'Disk usage limit'),
            'autoanswer'    => Yii::t('hipanel:hosting', 'Auto answer'),
            'spam_action' => Yii::t('hipanel:hosting', 'Spam action'),
            'mail'          => Yii::t('hipanel', 'E-mail'),
        ]);
    }

    public function canChangePassword()
    {
        return $this->type !== static::TYPE_FORWARD_ONLY && $this->state !== 'deleted';
    }

    public function attributeHints()
    {
        return [
            'forwards' => Yii::t('hipanel:hosting', 'All messages will be forwarded on the specified addresses. You can select email from the list of existing or wright down your own.'),
            'password' => $this->type === static::TYPE_FORWARD_ONLY
                            ? Yii::t('hipanel:hosting', 'Password change is prohibited on forward-only mailboxes')
                            : ($this->isNewRecord
                                ? Yii::t('hipanel:hosting', 'Leave this field empty to create a forward-only mailbox')
                                : Yii::t('hipanel:hosting', 'Fill this field only if you want to change the password')
                            ),
        ];
    }

    public static function getTypes()
    {
        return [
            'mailbox' => Yii::t('hipanel:hosting', 'Mailbox'),
            'forward_only' => Yii::t('hipanel:hosting', 'Forward only'),
            'mailbox_with_forwards' => Yii::t('hipanel:hosting', 'Mailbox with forwards'),
        ];
    }
}
