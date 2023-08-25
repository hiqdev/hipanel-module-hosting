<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\widgets\ip;

use hiqdev\combo\Combo;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * Class HdomainIpCombo.
 */
class HdomainIpCombo extends Combo
{
    /** {@inheritdoc} */
    public $type = 'hosting/hdomain-ip';

    /** {@inheritdoc} */
    public $name = 'hdomain-ip';

    /** {@inheritdoc} */
    public $url = '/hosting/ip/index';

    /** {@inheritdoc} */
    public $_return = [
        'id',
        'expanded_ips',
        'links',
    ];

    public $_rename = [
        'text' => 'ip',
    ];

    /** {@inheritdoc} */
    public $_filter = [
        'client' => 'client/client',
        'server' => 'server/server',
    ];

    public function getPluginOptions($options = [])
    {
        return parent::getPluginOptions(ArrayHelper::merge([
            'activeWhen'     => [
                'hosting/account',
            ],
            'select2Options' => [
                'ajax' => [
                    'processResults' => new JsExpression('
                        function (data) {
                            var ret = [];
                            var used_ips = {};
                            $.each(data, function (i, v) {
                                $.each(v.expanded_ips, function (ip, ipval) {
                                    if (used_ips[ip]) return;

                                    var row = {id: ip};
                                    used_ips[ip] = true
                                    if (v.links) {
                                        $.each(v.links, function(k,link) {
                                            row.text = ip;
                                            row.service = link.service;
                                        });
                                    } else {
                                        row.text = ip;
                                    }
                                    ret.push(row);
                                });
                            });

                            return {results: ret};
                        }
                '),
                ],
                'templateResult' => new JsExpression("
                    function (data) {
                        if (data.loading || !data.service) {
                            return data.text;
                        }

                        return data.service + ': ' + data.text;
                    }
                "),
                'templateSelection' => new JsExpression("
                    function (row) {
                        if (!row.service) return row.text;
                        return row.service + ': ' + row.text;
                    }
                "),
            ],
        ], $options));
    }

    /** {@inheritdoc} */
    public function getFilter()
    {
        return ArrayHelper::merge(parent::getFilter(), [
            'soft_type'             => ['format' => 'web'],
            'state_in'              => ['format' => ['ok']],
            'not_tags'              => ['format' => 'aux'],
            'with_links'            => ['format' => '1'],
            'show_only_device_link' => ['format' => '1'],
            'with_expanded_ips'     => ['format' => '1'],
        ]);
    }
}
