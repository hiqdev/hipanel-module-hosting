<?php

namespace hipanel\modules\hosting\tests\acceptance\admin;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Step\Acceptance\Admin;

class RequestsCest
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
        $I->needPage(Url::to('@request'));
        $I->see('Requests', 'h1');
        $this->ensureICanSeeAdvancedSearchBox($I);
        $this->ensureICanSeeLegendBox();
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox(Admin $I)
    {
        $this->index->containsFilters([
            Select2::asAdvancedSearch($I, 'Server'),
            Select2::asAdvancedSearch($I, 'Account'),
            Select2::asAdvancedSearch($I, 'Status'),
            Select2::asAdvancedSearch($I, 'Object'),
            Select2::asAdvancedSearch($I, 'Client'),
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
