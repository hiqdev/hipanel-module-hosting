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
        'after'     => ['servers', 'domains', 'tickets', 'finance', 'clients', 'dashboard'],
        'before'    => ['stock'],
    ];

    public function items()
    {
        return [
            'hosting' => [
                'label' => Yii::t('app', 'Hosting'),
                'url'   => '#',
                'icon'  => 'fa-sitemap',
                'items' => [
                    'accounts' => [
                        'label' => Yii::t('app', 'Accounts'),
                        'url'   => ['/hosting/account/index'],
                        'icon'  => 'fa-user',
                    ],
                    'dbs' => [
                        'label' => Yii::t('app', 'Databases'),
                        'url'   => ['/hosting/db/index'],
                        'icon'  => 'fa-database',
                    ],
                    'hdomains' => [
                        'label'   => Yii::t('app', 'Domains'),
                        'url'     => ['/hosting/hdomain/index'],
                        'icon'    => 'fa-globe',
                        'visible' => function () { return (bool)Yii::getAlias('@domain', false); },
                    ],
                    'mails' => [
                        'label'   => Yii::t('app', 'Mailboxes'),
                        'url'     => ['/hosting/mail/index'],
                        'icon'    => 'fa-mail',
                        'visible' => function () { return (bool)Yii::getAlias('@mail', false); },
                    ],
                    'backup' => [
                        'label'   => Yii::t('app', 'Backups'),
                        'url'     => ['/hosting/backup/index'],
                    ],
                    'backuping' => [
                        'label'   => Yii::t('app', 'Backup settings'),
                        'url'     => ['/hosting/backuping/index'],
                    ],
                    'crontab' => [
                        'label'   => Yii::t('app', 'Crons'),
                        'url'     => ['/hosting/crontab/index'],
                    ],
                    'ip' => [
                        'label'   => Yii::t('app', 'IP'),
                        'url'     => ['/hosting/ip/index'],
                    ],
                    'service' => [
                        'label'   => Yii::t('app', 'Service'),
                        'url'     => ['/hosting/service/index'],
                    ],
                ],
            ],
        ];
    }
}
