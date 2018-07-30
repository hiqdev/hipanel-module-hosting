<?php

namespace hipanel\modules\hosting\tests\acceptance\client;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Step\Acceptance\Client;

class BackupsCest
{
    /**
     * @var IndexPage
     */
    private $index;

    public function _before(Client $I)
    {
        $this->index = new IndexPage($I);
    }

    public function ensureIndexPageWorks(Client $I)
    {
        $I->login();
        $I->needPage(Url::to('@backuping'));
        $I->see('Backups', 'h1');
        $this->ensureICanSeeAdvancedSearchBox($I);
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox(Client $I)
    {
        $I->see('Advanced search', 'h3');

        $formId = 'form-advancedsearch-backuping-search';
        $this->index->containsFilters($formId, []);

        $I->see('State', "//form[@id='$formId']//span");
        $I->see('Account', "//form[@id='$formId']//span");
        $I->see('Server', "//form[@id='$formId']//span");
    }

    private function ensureICanSeeBulkSearchBox()
    {
        $this->index->containsBulkButtons([
            ["//button[@type='submit']" => 'Enable'],
            ["//button[@type='submit']" => 'Disable'],
            ["//button[@type='submit']" => 'Delete'],
        ]);
        $this->index->containsColumns('bulk-backuping-search', [
            'Name',
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
