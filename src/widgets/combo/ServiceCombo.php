<?php

namespace hipanel\modules\hosting\widgets\combo;

use hiqdev\combo\Combo;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;


/**
 * Class Service
 */
class ServiceCombo extends Combo
{
    /** @inheritdoc */
    public $name = 'name';

    /** @inheritdoc */
    public $type = 'hosting/service';

    /** @inheritdoc */
    public $url = '/hosting/service/index';

    /** @inheritdoc */
    public $_return = ['id', 'client', 'client_id', 'server', 'server_id', 'seller', 'seller_id', 'soft'];

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
            'server/server' => 'server',
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