<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\menus;

use Yii;

class SidebarMenu extends \hiqdev\yii2\menus\Menu
{
    public function items()
    {
        $user = Yii::$app->user;

        $hostingItems = [
            'accounts' => [
                'label' => Yii::t('hipanel:hosting', 'Accounts'),
                'url' => ['/hosting/account/index'],
                'icon' => 'fa-user',
                'visible' => $user->can('account.read'),
            ],
            'dbs' => [
                'label' => Yii::t('hipanel:hosting', 'Databases'),
                'url' => ['/hosting/db/index'],
                'icon' => 'fa-database',
                'visible' => $user->can('db.read'),
            ],
            'hdomains' => [
                'label' => Yii::t('hipanel:hosting', 'Domains'),
                'url' => ['/hosting/hdomain/index'],
                'icon' => 'fa-globe',
                'visible' => $user->can('hdomain.read'),
            ],
            'mails' => [
                'label' => Yii::t('hipanel:hosting', 'Mailboxes'),
                'url' => ['/hosting/mail/index'],
                'icon' => 'fa-envelope-o',
                'visible' => ((bool) Yii::getAlias('@mail', false)) && $user->can('mail.read'),
            ],
            'backuping' => [
                'label' => Yii::t('hipanel:hosting', 'Backup statistics'),
                'icon' => 'fa-archive',
                'url' => ['/hosting/backuping/index'],
                'visible' => $user->can('backuping.read'),
            ],
            'backup' => [
                'label' => Yii::t('hipanel:hosting', 'Backups'),
                'icon' => 'fa-archive',
                'url' => ['/hosting/backup/index'],
                'visible' => $user->can('backup.read'),
            ],
            'crontab' => [
                'label' => Yii::t('hipanel:hosting', 'Crons'),
                'icon' => 'fa-clock-o',
                'url' => ['/hosting/crontab/index'],
                'visible' => $user->can('crontab.read'),
            ],
            'ip' => [
                'label' => Yii::t('hipanel:hosting', 'IP addresses'),
                'icon' => 'fa-location-arrow',
                'url' => ['/hosting/ip/index'],
                'visible' => $user->can('ip.read'),
            ],
            'service' => [
                'label' => Yii::t('hipanel:hosting', 'Services'),
                'icon' => 'fa-terminal',
                'url' => ['/hosting/service/index'],
                'visible' => $user->can('service.read'),
            ],
            'request' => [
                'label' => Yii::t('hipanel:hosting', 'Requests'),
                'icon' => 'fa-tasks',
                'url' => ['/hosting/request/index'],
                'visible' => $user->can('request.read'),
            ],
        ];

        $isHostingVisible = false;
        foreach ($hostingItems as $sub) {
            if ((bool) $sub['visible'] === true || !isset($sub['visible'])) {
                $isHostingVisible = true;
                break;
            }
        }

        $showItems = $isHostingVisible && (
            Yii::$app->params['module.hosting.is_public']
            || $user->can('support')
        );

        return [
            'hosting' => [
                'label' => Yii::t('hipanel:hosting', 'Managed Hosting'),
                'url' => '#',
                'icon' => 'fa-sitemap',
                'visible' => $user->can('dns.read') || $isHostingVisible,
                'items' => $showItems ? $hostingItems : [],
            ],
        ];
    }
}
