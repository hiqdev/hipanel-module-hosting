<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\widgets\combo;

use hipanel\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * Class Account.
 */
class SshAccountCombo extends AccountCombo
{
    /** {@inheritdoc} */
    public $accountType = 'user';

    /** {@inheritdoc} */
    public function getPluginOptions($options = [])
    {
        return ArrayHelper::merge(parent::getPluginOptions($options), [
            'select2Options' => [
                'templateResult' => new JsExpression("function (data) {
                    if (data.loading) {
                        return data.text;
                    }
                    var name = data.login;
                    if (typeof name === 'undefined') {
                        name = data.account;
                    }

                    return name + '<small>@' + data.device + '</small>';
                }"),
                'escapeMarkup' => new JsExpression('function (markup) {
                    return markup; // Allows HTML
                }'),
            ],
        ]);
    }
}
