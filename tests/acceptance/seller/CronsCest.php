<?php

namespace hipanel\modules\hosting\tests\acceptance\seller;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Step\Acceptance\Seller;

class CronsCest
{
    /**
     * @var IndexPage
     */
    private $index;

    public function _before(Seller $I)
    {
        $this->index = new IndexPage($I);
    }

    public function ensureIndexPageWorks(Seller $I)
    {
        $I->login();
        $I->needPage(Url::to('@crontab'));
        $I->see('Crons', 'h1');
        $this->ensureICanSeeAdvancedSearchBox();
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox()
    {
        $this->index->containsFilters([
            new Select2('Account'),
            new Select2('Server'),
            new Select2('Client'),
        ]);
    }

    private function ensureICanSeeBulkSearchBox()
    {
        $this->index->containsColumns([
            'Crontab',
            'Account',
            'Server',
            'Client',
            'Status',
        ]);
    }
}
