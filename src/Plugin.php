<?php

namespace hipanel\modules\hosting;

class Plugin extends \hiqdev\pluginmanager\Plugin
{
    protected $_items = [
        'aliases' => [
            "@account" => "/hosting/account",
            "@hdomain" => "/hosting/hdomain",
            "@db"      => "/hosting/db",
        ],
        'menus' => [
            'hipanel\modules\hosting\SidebarMenu',
        ],
        'modules' => [
            'hosting' => [
                'class' => 'hipanel\modules\hosting\Module',
            ],
        ],
    ];
}
