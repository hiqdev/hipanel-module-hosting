<?php

namespace hipanel\modules\hosting\tests\acceptance\seller;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Step\Acceptance\Seller;

class RequestsCest
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
        $I->needPage(Url::to('@request'));
        $I->see('Requests', 'h1');
        $this->ensureICanSeeAdvancedSearchBox();
        $this->ensureICanSeeLegendBox();
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox()
    {
        $this->index->containsFilters([
            new Select2('Server'),
            new Select2('Account'),
            new Select2('Status'),
            new Select2('Object'),
            new Select2('Client'),
        ]);
    }

    private function ensureICanSeeLegendBox()
    {
        $this->index->containsLegend([
            'Scheduled time:',
            'Already',
            'Deferred',
            'State:',
            'New',
            'In progress',
            'Done',
            'Error',
            'Buzzed',
        ]);
    }

    private function ensureICanSeeBulkSearchBox()
    {
        $this->index->containsBulkButtons([
            'Delete',
        ]);
        $this->index->containsColumns([
            'Action',
            'Server',
            'Account',
            'Object',
            'Time',
            'Status',
        ]);
    }
}
