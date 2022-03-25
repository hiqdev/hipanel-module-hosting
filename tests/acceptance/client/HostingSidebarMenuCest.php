<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\tests\acceptance\client;

use hipanel\tests\_support\Page\SidebarMenu;
use hipanel\tests\_support\Step\Acceptance\Client;
use Yii;

class HostingSidebarMenuCest
{
    public function ensureMenuIsOk(Client $I): void
    {
        if (!Yii::$app->params['module.hosting.is_public']) {
            $I->markTestSkipped('Test is not allowed for client');
        }
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
