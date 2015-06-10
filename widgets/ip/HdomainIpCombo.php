<?php

namespace hipanel\modules\hosting\widgets\ip;

use hiqdev\combo\Combo;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;


/**
 * Class HdomainIpCombo
 */
class HdomainIpCombo extends Combo
{
    /** @inheritdoc */
    public $type = 'hosting/hdomain-ip';

    /** @inheritdoc */
    public $name = 'hdomain-ip';

    /** @inheritdoc */
    public $url = '/hosting/ip/search';

    /** @inheritdoc */
    public $_return = [
        'id',
        'expanded_ips'
    ];

    public $_rename = [
        'text' => 'ip'
    ];

    /** @inheritdoc */
    public $_filter = [
        'client' => 'client/client',
        'server' => 'server/server',
    ];

    public function getPluginOptions()
    {
        return parent::getPluginOptions([
            'activeWhen'     => [
                'hosting/account',
            ],
            'select2Options' => [
                'ajax' => [
                    'results'      => new JsExpression("
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
                                            row.text = link.service + ': ' + ip;
                                        });
                                    } else {
                                        row.text = ip;
                                    }
                                    ret.push(row);
                                });
                            });

                            return {results: ret};
                        }
                ")
                ],
            ]
        ]);
    }

    /** @inheritdoc */
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