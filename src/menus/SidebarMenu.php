<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\menus;

use Yii;

class SidebarMenu extends \hiqdev\yii2\menus\Menu
{
    public function items()
    {
        return [
            'hosting' => [
                'label' => Yii::t('hipanel:hosting', 'Hosting'),
                'url' => '#',
                'icon' => 'fa-sitemap',
                'visible' => Yii::$app->user->can('account.read'),
                'items' => [
                    'accounts' => [
                        'label' => Yii::t('hipanel:hosting', 'Accounts'),
                        'url' => ['/hosting/account/index'],
                        'icon' => 'fa-user',
                    ],
                    'dbs' => [
                        'label' => Yii::t('hipanel:hosting', 'Databases'),
                        'url' => ['/hosting/db/index'],
                        'icon' => 'fa-database',
                    ],
                    'hdomains' => [
                        'label' => Yii::t('hipanel:hosting', 'Domains'),
                        'url' => ['/hosting/hdomain/index'],
                        'icon' => 'fa-globe',
                    ],
                    'mails' => [
                        'label' => Yii::t('hipanel:hosting', 'Mailboxes'),
                        'url' => ['/hosting/mail/index'],
                        'icon' => 'fa-envelope-o',
                        'visible' => function () {
                            return (bool) Yii::getAlias('@mail', false);
                        },
                    ],
                    'backuping' => [
                        'label' => Yii::t('hipanel:hosting', 'Backups'),
                        'icon' => 'fa-archive',
                        'url' => ['/hosting/backuping/index'],
                    ],
                    'crontab' => [
                        'label' => Yii::t('hipanel:hosting', 'Crons'),
                        'icon' => 'fa-clock-o',
                        'url' => ['/hosting/crontab/index'],
                    ],
                    'ip' => [
                        'label' => Yii::t('hipanel:hosting', 'IP addresses'),
                        'icon' => 'fa-location-arrow',
                        'url' => ['/hosting/ip/index'],
                    ],
                    'service' => [
                        'label' => Yii::t('hipanel:hosting', 'Services'),
                        'icon' => 'fa-terminal',
                        'url' => ['/hosting/service/index'],
                    ],
                    'request' => [
                        'label' => Yii::t('hipanel:hosting', 'Requests'),
                        'icon' => 'fa-tasks',
                        'url' => ['/hosting/request/index'],
                    ],
                ],
            ],
        ];
    }
}
