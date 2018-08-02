<?php

namespace hipanel\modules\hosting\tests\acceptance\admin;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Step\Acceptance\Admin;

class IPAddressesCest
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
        $I->needPage(Url::to('@ip'));
        $I->see('IP addresses', 'h1');
        $this->ensureICanSeeAdvancedSearchBox();
        $this->ensureICanSeeLegendBox();
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox()
    {
        $this->index->containsFilters([
            new Input('IP'),
            new Select2('Servers'),
            new Input('Tags'),
        ]);
    }

    private function ensureICanSeeLegendBox()
    {
        $this->index->containsLegend([
            'Shared',
            'Free',
            'Dedicated',
            'System',
            'Blocked',
        ]);
    }

    private function ensureICanSeeBulkSearchBox()
    {
        $this->index->containsColumns([
            'IP',
            'Note',
            'Tags',
            'Counters',
            'Links',
        ]);
    }
}
