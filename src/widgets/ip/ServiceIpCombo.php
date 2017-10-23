<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\widgets\ip;

use hiqdev\combo\Combo;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * Class ServiceIpCombo.
 */
class ServiceIpCombo extends Combo
{
    /** {@inheritdoc} */
    public $type = 'hosting/hdomain-ip';

    /** {@inheritdoc} */
    public $name = 'hdomain-ip';

    /** {@inheritdoc} */
    public $url = '/hosting/ip/search-service-edit';

    /** {@inheritdoc} */
    public $_return = [
        'id',
        'links',
        'expanded_ips',
    ];

    public $_rename = [
        'text' => 'ip',
    ];

    /** {@inheritdoc} */
    public $_filter = [
        'server' => 'server/server',
    ];

    /** {@inheritdoc} */
    public $multiple = true;

    public function getPluginOptions($options = [])
    {
        return parent::getPluginOptions(ArrayHelper::merge([
            'activeWhen'     => [
                'server/server',
            ],
            'select2Options' => [
                'tokenSeparators' => [',', ' '],
                'tags' => true,
                'allowClear' => true,
                'templateResult' => new JsExpression("function (data) {
                    if (data.loading || !data.device) {
                        return data.text;
                    }

                    return data.device + ': ' + data.text;
                }"),
                'createTag' => new JsExpression(/** @lang javascript */"
                    function (query) {
                        var ipv6_regex = /^((([0-9a-f]{1,4}:){7}[0-9a-f]{1,4})|(([0-9a-f]{1,4}:){6}:[0-9a-f]{1,4})|(([0-9a-f]{1,4}:){5}:([0-9a-f]{1,4}:)?[0-9a-f]{1,4})|(([0-9a-f]{1,4}:){4}:([0-9a-f]{1,4}:){0,2}[0-9a-f]{1,4})|(([0-9a-f]{1,4}:){3}:([0-9a-f]{1,4}:){0,3}[0-9a-f]{1,4})|(([0-9a-f]{1,4}:){2}:([0-9a-f]{1,4}:){0,4}[0-9a-f]{1,4})|(([0-9a-f]{1,4}:){6}((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|(([0-9a-f]{1,4}:){0,5}:((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|(::([0-9a-f]{1,4}:){0,5}((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|([0-9a-f]{1,4}::([0-9a-f]{1,4}:){0,5}[0-9a-f]{1,4})|(::([0-9a-f]{1,4}:){0,6}[0-9a-f]{1,4})|(([0-9a-f]{1,4}:){1,7}:))(\/([1-9][0-9]?|1[01][0-9]|12[0-8]))?$/i,
                            ipv4_regex = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(\/([1-9]|1[0-9]|2[0-9]|3[0-2]))?$/i,
                            term = query.term;

                        if (term.match(ipv4_regex) || term.match(ipv6_regex)) {
                            return {
                                id: term,
                                text: term,
                                tag: true
                            };
                        }

                        return null;
                    }
                "),
            ],
        ], $options));
    }

    /** {@inheritdoc} */
    public function getFilter()
    {
        return ArrayHelper::merge(parent::getFilter(), [
            'state_in'              => ['format' => ['ok']],
            'not_tags'              => ['format' => 'aux'],
        ]);
    }
}
