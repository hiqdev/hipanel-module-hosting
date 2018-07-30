<?php

namespace hipanel\modules\hosting\tests\acceptance\client;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Step\Acceptance\Client;

class CronsCest
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
        $I->needPage(Url::to('@crontab'));
        $I->see('Crons', 'h1');
        $this->ensureICanSeeAdvancedSearchBox($I);
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox(Client $I)
    {
        $I->see('Advanced search', 'h3');

        $formId = 'form-advancedsearch-crontab-search';
        $this->index->containsFilters($formId, []);

        $I->see('Account', "//form[@id='$formId']//span");
        $I->see('Server', "//form[@id='$formId']//span");
    }

    private function ensureICanSeeBulkSearchBox()
    {
        $this->index->containsColumns('bulk-crontab-search', [
            'Crontab',
            'Account',
            'Server',
            'Status',
        ]);
    }
}
