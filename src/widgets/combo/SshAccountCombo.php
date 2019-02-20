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

                    return data.client + '@' + data.device;
                }"),
            ],
        ]);
    }
}
