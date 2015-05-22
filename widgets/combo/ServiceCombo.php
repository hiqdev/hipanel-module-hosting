<?php

namespace hipanel\modules\hosting\widgets\combo;

use hiqdev\combo\Combo;
use yii\helpers\ArrayHelper;


/**
 * Class Service
 */
class ServiceCombo extends Combo
{
    /** @inheritdoc */
    public $type = 'hosting/service';

    /** @inheritdoc */
    public $name = 'name';

    /** @inheritdoc */
    public $url = '/hosting/service/search';

    /** @inheritdoc */
    public $_return = ['id', 'client', 'client_id', 'device', 'device_id', 'seller', 'seller_id'];

    /** @inheritdoc */
    public $_rename = ['text' => 'name'];

    /** @inheritdoc */
    public $_filter = [
        'client' => 'client/client',
        'server' => 'server/server',
    ];

    /**
     * @var string the soft type, used by [[getFilter]] to filter by the soft type
     * @see getFilter()
     */
    public $softType;

    public $_pluginOptions = [
        'activeWhen' => [
            'server/server',
        ],
        'affects'    => [
            'client/seller' => 'seller',
            'client/client' => 'client',
            'server/server' => 'device',
        ]
    ];

    /** @inheritdoc */
    public function getFilter()
    {
        return ArrayHelper::merge(parent::getFilter(), [
            'soft_type' => ['format' => $this->softType]
        ]);
    }
}