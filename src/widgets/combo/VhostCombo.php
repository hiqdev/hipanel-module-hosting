<?php

namespace hipanel\modules\hosting\widgets\combo;

use hiqdev\combo\Combo;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * Class Account
 */
class VhostCombo extends Combo
{
    /** @inheritdoc */
    public $type = 'hosting/vhost';

    /** @inheritdoc */
    public $name = 'domain';

    /** @inheritdoc */
    public $url = '/hosting/vhost/index';

    /** @inheritdoc */
    public $_return = ['id', 'domain', 'account', 'server', 'service', 'ip', 'port'];

    /** @inheritdoc */
    public $_rename = ['text' => 'domain'];

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
            'clearWhen' => ['server/server'],
            'activeWhen' => ['server/server', 'hosting/account'],
            'select2Options' => [
                'formatResult' => new JsExpression("function (data) {
                    return data.domain + '<br><small>' +  data.service + ' - ' + data.ip + ':' + data.port + '</small>';
                }")
            ]
        ]);
    }
}