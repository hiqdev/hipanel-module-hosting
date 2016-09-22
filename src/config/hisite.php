<?php

/*
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

return [
    'aliases' => [
        "@account"      => "/hosting/account",
        "@hdomain"      => "/hosting/hdomain",
        "@db"           => "/hosting/db",
        "@mail"         => "/hosting/mail",
        "@backup"       => "/hosting/backup",
        "@backuping"    => "/hosting/backuping",
        "@service"      => "/hosting/service",
        "@ip"           => "/hosting/ip",
    ],
    'modules' => [
        'hosting' => [
            'class' => \hipanel\modules\hosting\Module::class,
        ],
    ],
    'components' => [
        'i18n' => [
            'translations' => [
                'hipanel/hosting*' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => '@hipanel/modules/hosting/messages',
                    'fileMap' => [
                        'hipanel/hosting' => 'hosting.php',
                        'hipanel/hosting/backuping/periodicity' => 'backuping_periodicity.php',
                        'hipanel/hosting/cron/states' => 'cron_states.php',
                    ],
                ],
            ],
        ],
        'menuManager' => [
            'items' => [
                'sidebar' => [
                    'add' => [
                        'hosting' => [
                            'menu' => \hipanel\modules\hosting\menus\SidebarHostingMenu::class,
                            'where' => [
                                'after' => ['servers', 'domains', 'tickets', 'finance', 'clients', 'dashboard'],
                                'before' => ['stock'],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
