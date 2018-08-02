<?php

namespace hipanel\modules\hosting\tests\acceptance\admin;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Step\Acceptance\Admin;

class BackupsCest
{
    /**
     * @var IndexPage
     */
    private $index;

    public function _before(Admin $I)
    {
        $this->index = new IndexPage($I);
    }

    public function ensureIndexPageWorks(Admin $I)
    {
        $I->login();
        $I->needPage(Url::to('@backuping'));
        $I->see('Backups', 'h1');
        $this->ensureICanSeeAdvancedSearchBox();
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox()
    {
        $this->index->containsFilters([
            new Select2('State'),
            new Select2('Account'),
            new Select2('Server'),
            new Select2('Client'),
        ]);
    }

    private function ensureICanSeeBulkSearchBox()
    {
        $this->index->containsBulkButtons([
            'Enable',
            'Disable',
            'Delete',
        ]);
        $this->index->containsColumns([
            'Name',
            'Client',
            'Account',
            'Server',
            'Count',
            'Periodicity',
            'State',
            'Last backup',
            'Disk usage',
        ]);
    }
}
