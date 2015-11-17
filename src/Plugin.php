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
        'translations' => [
            'hipanel/hosting' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@hipanel/modules/hosting/messages',
                'fileMap' => [
                    'hipanel/hosting' => 'hosting.php',
                ]
            ]
        ]
    ];
}
