<?php

/*
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\widgets\combo;

use hiqdev\combo\Combo;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * Class HdomainCombo
 * @package hipanel\modules\hosting\widgets\combo
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

    /**
     * @var array used in [[getPluginOptions()]]
     */
    public $activeWhen = ['hosting/vhost'];

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
        return parent::getPluginOptions(ArrayHelper::merge([
            'activeWhen' => $this->activeWhen,
            'select2Options' => [
                'formatResult' => new JsExpression("function (data) {
                    return data.text + ' - ' + data.server;
                }")
            ]
        ], $options));
    }
}
