<?php

namespace hipanel\modules\hosting\widgets\combo;

use hiqdev\combo\Combo;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * Class Account
 */
class HdomainCombo extends Combo
{
    /** @inheritdoc */
    public $type = 'hosting/hdomain';

    /** @inheritdoc */
    public $name = 'login';

    /** @inheritdoc */
    public $url = '/hosting/hdomain/index';

    /** @inheritdoc */
    public $_return = ['id', 'server'];

    /** @inheritdoc */
    public $_rename = ['text' => 'domain'];

    /** @inheritdoc */
    public function getFilter()
    {
        return ArrayHelper::merge(parent::getFilter(), [
            'server' => 'server/server',
            'account' => 'hosting/account',
        ]);
    }

    /** @inheritdoc */
    public function getPluginOptions($options = [])
    {
        return parent::getPluginOptions([
            'activeWhen' => ['hosting/vhost'],
            'select2Options' => [
                'formatResult' => new JsExpression("function (data) {
                    return data.text + ' - ' + data.server;
                }")
            ]
        ]);
    }
}