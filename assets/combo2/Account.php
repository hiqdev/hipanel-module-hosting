<?php

namespace hipanel\modules\hosting\assets\combo2;

use hipanel\widgets\Combo2Config;
use yii\helpers\ArrayHelper;

/**
 * Class Account
 */
class Account extends Combo2Config
{
    /** @inheritdoc */
    public $type = 'hosting/account';

    /** @inheritdoc */
    public $name = 'login';

    /** @inheritdoc */
    public $url = '/hosting/account/search';

    /** @inheritdoc */
    public $_return = ['id', 'client', 'client_id', 'device', 'device_id'];

    /** @inheritdoc */
    public $_rename = ['text' => 'login'];

    /** @inheritdoc */
    public $_filter = [
        'client' => 'client/client',
        'server' => 'server/server',
    ];

    /** @inheritdoc */
    function getConfig($config = [])
    {
        $config = ArrayHelper::merge([
            'clearWhen' => ['client/client', 'server/server'],
            'affects'   => [
                'client/seller' => 'seller',
                'client/client' => 'client',
                'server/server' => 'device',
            ]
        ], $config);

        return parent::getConfig($config);
    }
}