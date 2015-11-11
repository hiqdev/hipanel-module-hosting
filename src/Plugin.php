<?php

namespace hipanel\modules\hosting;

class Plugin extends \hiqdev\pluginmanager\Plugin
{
    protected $_items = [
        'aliases' => [
            "@account" => "/hosting/account",
            "@hdomain" => "/hosting/hdomain",
            "@db"      => "/hosting/db",
            "@mail"    => "/hosting/mail",
            "@backup"  => "/hosting/backup",
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
