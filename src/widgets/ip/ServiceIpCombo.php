<?php

/*
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\widgets\ip;

use hiqdev\combo\Combo;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * Class ServiceIpCombo
 */
class ServiceIpCombo extends Combo
{
    /** @inheritdoc */
    public $type = 'hosting/hdomain-ip';

    /** @inheritdoc */
    public $name = 'hdomain-ip';

    /** @inheritdoc */
    public $url = '/hosting/ip/search-service-edit';

    /** @inheritdoc */
    public $_return = [
        'id',
        'links',
        'expanded_ips',
    ];

    public $_rename = [
        'text' => 'ip'
    ];

    /** @inheritdoc */
    public $_filter = [
        'server' => 'server/server',
    ];

    public function getPluginOptions($options = [])
    {
        return parent::getPluginOptions(ArrayHelper::merge([
            'activeWhen'     => [
                'server/server',
            ],
            'select2Options' => [
                'multiple' => true,
                'tokenSeparators' => [',', " "],
                'tags' => true,
                'allowClear' => true,
                'formatResult' => new JsExpression("
                    function(row) {
                        if (!row.device) return row.text;
                        return row.device + ': ' + row.text;
                    }
                "),
//                'formatSelection' => new JsExpression("
//                    function(row) {
//                        if (!row.service) return row.text;
//                        return row.service + ': ' + row.text;
//                    }
//                "),
                'createSearchChoice' => new JsExpression(/** @lang javascript */"
                    function (term, data) {
                        var ipv6_regex = /^((([0-9a-f]{1,4}:){7}[0-9a-f]{1,4})|(([0-9a-f]{1,4}:){6}:[0-9a-f]{1,4})|(([0-9a-f]{1,4}:){5}:([0-9a-f]{1,4}:)?[0-9a-f]{1,4})|(([0-9a-f]{1,4}:){4}:([0-9a-f]{1,4}:){0,2}[0-9a-f]{1,4})|(([0-9a-f]{1,4}:){3}:([0-9a-f]{1,4}:){0,3}[0-9a-f]{1,4})|(([0-9a-f]{1,4}:){2}:([0-9a-f]{1,4}:){0,4}[0-9a-f]{1,4})|(([0-9a-f]{1,4}:){6}((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|(([0-9a-f]{1,4}:){0,5}:((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|(::([0-9a-f]{1,4}:){0,5}((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|([0-9a-f]{1,4}::([0-9a-f]{1,4}:){0,5}[0-9a-f]{1,4})|(::([0-9a-f]{1,4}:){0,6}[0-9a-f]{1,4})|(([0-9a-f]{1,4}:){1,7}:))(\/([1-9][0-9]?|1[01][0-9]|12[0-8]))?$/i;
                        var ipv4_regex = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(\/([1-9]|1[0-9]|2[0-9]|3[0-2]))?$/i;

                        if ($(data).filter(function () {
                                return this.text.localeCompare(term) === 0;
                            }).length === 0) {
                            if (term.match(ipv4_regex) || term.match(ipv6_regex)) {
                                return {
                                    id: term,
                                    text: term
                                };
                            }
                        }
                    }
                ")
            ]
        ], $options));
    }

    /** @inheritdoc */
    public function getFilter()
    {
        return ArrayHelper::merge(parent::getFilter(), [
            'state_in'              => ['format' => ['ok']],
            'not_tags'              => ['format' => 'aux'],
        ]);
    }
}
