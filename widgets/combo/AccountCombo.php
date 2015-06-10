<?php

namespace hipanel\modules\hosting\widgets\combo;

use hiqdev\combo\Combo;
use yii\helpers\ArrayHelper;

/**
 * Class Account
 */
class AccountCombo extends Combo
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

    public function getPluginOptions($config) {
        return parent::getPluginOptions([
            'clearWhen' => ['client/client', 'server/server'],
            'affects'   => [
                'client/seller' => 'seller',
                'client/client' => 'client',
                'server/server' => 'device',
            ]
        ]);
    }
}