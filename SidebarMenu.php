<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting;

class SidebarMenu extends \hipanel\base\Menu implements \yii\base\BootstrapInterface
{

    /**
     * @inheritdoc
     */
    protected $_addTo = 'sidebar';

    protected $_where = [
        'after'     => ['servers', 'domains', 'tickets', 'finance', 'clients', 'dashboard'],
    ];

    protected $_items = [
        'hosting' => [
            'label' => 'Hosting',
            'url'   => '#',
            'icon'  => 'fa-sitemap',
            'items' => [
                'accounts' => [
                    'label' => 'Accounts',
                    'url'   => ['/hosting/account/index'],
                    'icon'  => 'fa-user',
                ],
                'dbs' => [
                    'label' => 'DataBases',
                    'url'   => ['/hosting/db/index'],
                    'icon'  => 'fa-database',
                ],
            ],
        ],
    ];

}
