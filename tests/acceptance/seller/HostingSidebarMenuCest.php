<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\tests\acceptance\seller;

use hipanel\tests\_support\Page\SidebarMenu;
use hipanel\tests\_support\Step\Acceptance\Seller;

class HostingSidebarMenuCest
{
    public function ensureMenuIsOk(Seller $I)
    {
        (new SidebarMenu($I))->ensureContains('Hosting', [
            'Accounts' => '@account/index',
            'Databases' => '@db/index',
            'Domains' => '@hdomain/index',
            'Mailboxes' => '@mail/index',
            'Backup statistics' => '@backuping/index',
            'Backups' => '@backup/index',
            'Crons' => '@crontab/index',
            'IP addresses' => '@ip/index',
            'Services' => '@service/index',
            'Requests' => '@request/index',
            'DNS' => '@dns/zone/index',
        ]);
    }
}
