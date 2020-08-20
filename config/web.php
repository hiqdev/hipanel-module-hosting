<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

return [
    'aliases' => [
        '@account' => '/hosting/account',
        '@hdomain' => '/hosting/hdomain',
        '@db' => '/hosting/db',
        '@mail' => '/hosting/mail',
        '@backup' => '/hosting/backup',
        '@backuping' => '/hosting/backuping',
        '@service' => '/hosting/service',
        '@ip' => '/hosting/ip',
        '@request' => '/hosting/request',
        '@crontab' => '/hosting/crontab',
        '@aggregate' => '/hosting/aggregate',
        '@prefix' => '/hosting/prefix',
    ],
    'modules' => [
        'hosting' => [
            'class' => \hipanel\modules\hosting\Module::class,
        ],
    ],
    'components' => [
        'i18n' => [
            'translations' => [
                'hipanel:hosting' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => dirname(__DIR__) . '/src/messages',
                ],
                'hipanel.hosting.backuping.periodicity' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => dirname(__DIR__) . '/src/messages',
                ],
                'hipanel:hosting:cron:states' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => dirname(__DIR__) . '/src/messages',
                ],
                'hipanel:hosting:account' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => dirname(__DIR__) . '/src/messages',
                ],
                'hipanel.hosting.ipam' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => dirname(__DIR__) . '/src/messages',
                ],
            ],
        ],
    ],
    'container' => [
        'definitions' => [
            \hipanel\models\ObjClass::class => [
                'knownClasses' => [
                    'db' => [
                        'color' => 'info',
                        'label' => function () {
                            return Yii::t('hipanel:hosting', 'Database');
                        },
                    ],
                    'hdomain' => [
                        'color' => 'default',
                        'label' => function () {
                            return Yii::t('hipanel:hosting', 'Domain');
                        },
                    ],
                ],
            ],
            \hiqdev\thememanager\menus\AbstractSidebarMenu::class => [
                'add' => [
                    'hosting' => [
                        'menu' => [
                            'class' => \hipanel\modules\hosting\menus\SidebarMenu::class,
                        ],
                        'where' => [
                            'after' => ['servers', 'domains', 'tickets', 'finance', 'clients', 'dashboard'],
                            'before' => ['stock'],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
