<?php

namespace hipanel\modules\hosting\widgets\combo;

use hiqdev\combo\Combo;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

class MailCombo extends Combo
{
    /** @inheritdoc */
    public $type = 'hosting/mail';

    /** @inheritdoc */
    public $name = 'mail';

    /** @inheritdoc */
    public $url = '/hosting/mail/search';

    /** @inheritdoc */
    public $_return = ['id', 'account', 'server', 'client'];

    /** @inheritdoc */
    public $_rename = ['text' => 'mail'];

    /** @inheritdoc */
    public function getFilter()
    {
        return ArrayHelper::merge(parent::getFilter(), [
            'server' => 'server/server',
            'account' => 'hosting/account',
            'state' => ['format' => 'ok'],
        ]);
    }

    /** @inheritdoc */
    public function getPluginOptions($options = [])
    {
        return parent::getPluginOptions([
            'activeWhen' => ['server/server'],
            'select2Options' => [
                'formatResult' => new JsExpression("function (data) {
                    return data.text;
                }")
            ]
        ]);
    }
}