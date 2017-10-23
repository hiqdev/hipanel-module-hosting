<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\widgets\combo;

use hiqdev\combo\Combo;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * Class Account.
 */
class VhostCombo extends Combo
{
    /** {@inheritdoc} */
    public $type = 'hosting/vhost';

    /** {@inheritdoc} */
    public $name = 'domain';

    /** {@inheritdoc} */
    public $url = '/hosting/vhost/search';

    /** {@inheritdoc} */
    public $_return = ['id', 'domain', 'account', 'server', 'service', 'ip', 'port'];

    /** {@inheritdoc} */
    public $_rename = ['text' => 'domain'];

    public $activeWhen = ['server/server', 'hosting/account'];

    /** {@inheritdoc} */
    public function getFilter()
    {
        return ArrayHelper::merge(parent::getFilter(), [
            'server' => 'server/server',
            'account' => 'hosting/account',
            'state' => ['format' => 'ok'],
        ]);
    }

    /** {@inheritdoc} */
    public function getPluginOptions($options = [])
    {
        return parent::getPluginOptions([
            'clearWhen' => ['server/server'],
            'activeWhen' => $this->activeWhen,
            'select2Options' => [
                'templateResult' => new JsExpression("function (data) {
                    if (data.loading) {
                      return data.text;
                    }

                    return data.domain + '<br><small>' +  data.service + ' - ' + data.ip + ':' + data.port + '</small>';
                }"),
                'escapeMarkup' => new JsExpression('function (markup) {
                    return markup; // Allows HTML
                }'),
            ],
        ]);
    }
}
