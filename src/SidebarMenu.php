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
                        'label' => Yii::t('app', 'Domains'),
                        'url'   => ['/hosting/hdomain/index'],
                        'icon'  => 'fa-globe',
                    ]
                ],
            ],
        ];
    }
}
