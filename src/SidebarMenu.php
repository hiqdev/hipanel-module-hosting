<?php

namespace hipanel\modules\hosting;

use Yii;

class SidebarMenu extends \hipanel\base\Menu implements \yii\base\BootstrapInterface
{
    /**
     * @inheritdoc
     */
    protected $_addTo = 'sidebar';

    protected $_where = [
        'after' => ['servers', 'domains', 'tickets', 'finance', 'clients', 'dashboard'],
        'before' => ['stock'],
    ];

    public function items()
    {
        return [
            'hosting' => [
                'label' => Yii::t('hipanel/hosting', 'Hosting'),
                'url' => '#',
                'icon' => 'fa-sitemap',
                'items' => [
                    'accounts' => [
                        'label' => Yii::t('hipanel/hosting', 'Accounts'),
                        'url' => ['/hosting/account/index'],
                        'icon' => 'fa-user',
                    ],
                    'dbs' => [
                        'label' => Yii::t('hipanel/hosting', 'Databases'),
                        'url' => ['/hosting/db/index'],
                        'icon' => 'fa-database',
                    ],
                    'hdomains' => [
                        'label' => Yii::t('hipanel/hosting', 'Domains'),
                        'url' => ['/hosting/hdomain/index'],
                        'icon' => 'fa-globe',
                        'visible' => function () {
                            return (bool)Yii::getAlias('@domain', false);
                        },
                    ],
                    'mails' => [
                        'label' => Yii::t('hipanel/hosting', 'Mailboxes'),
                        'url' => ['/hosting/mail/index'],
                        'icon' => 'fa-envelope-o',
                        'visible' => function () {
                            return (bool)Yii::getAlias('@mail', false);
                        },
                    ],
                    'backup' => [
                        'label' => Yii::t('hipanel/hosting', 'Backups'),
                        'icon' => 'fa-archive',
                        'url' => ['/hosting/backup/index'],
                    ],
                    'backuping' => [
                        'label' => Yii::t('hipanel/hosting', 'Backup settings'),
                        'icon' => 'fa-cogs',
                        'url' => ['/hosting/backuping/index'],
                    ],
                    'crontab' => [
                        'label' => Yii::t('hipanel/hosting', 'Crons'),
                        'icon' => 'fa-clock-o',
                        'url' => ['/hosting/crontab/index'],
                    ],
                    'ip' => [
                        'label' => Yii::t('hipanel/hosting', 'IP addresses'),
                        'icon' => 'fa-location-arrow',
                        'url' => ['/hosting/ip/index'],
                    ],
                    'service' => [
                        'label' => Yii::t('hipanel/hosting', 'Services'),
                        'icon' => 'fa-terminal',
                        'url' => ['/hosting/service/index'],
                    ],
                    'request' => [
                        'label' => Yii::t('hipanel/hosting', 'Requests'),
                        'icon' => 'fa-tasks',
                        'url' => ['/hosting/request/index'],
                    ],
                ],
            ],
        ];
    }
}
