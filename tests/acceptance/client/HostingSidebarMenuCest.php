<?php

namespace hipanel\modules\hosting\tests\acceptance\client;

use hipanel\tests\_support\Page\SidebarMenu;
use hipanel\tests\_support\Step\Acceptance\Client;

class HostingSidebarMenuCest
{
    public function ensureMenuIsOk(Client $I)
    {
        (new SidebarMenu($I))->ensureContains('Hosting',[
            'Accounts' => '@account/index',
            'Databases' => '@db/index',
            'Domains' => '@hdomain/index',
            'Mailboxes' => '@mail/index',
            'Backups' => '@backuping/index',
            'Crons' => '@crontab/index',
            'IP addresses' => '@ip/index',
            'Services' => '@service/index',
            'Requests' => '@request/index',
        ]);
    }
}
