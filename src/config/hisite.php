<?php

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
            'menus' => [
                'hosting' => \hipanel\modules\hosting\SidebarMenu::class,
            ],
        ],
    ],
];
