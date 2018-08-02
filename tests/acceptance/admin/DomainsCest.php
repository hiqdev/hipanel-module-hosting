<?php

namespace hipanel\modules\hosting\tests\acceptance\admin;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Step\Acceptance\Admin;

class DomainsCest
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
        $I->needPage(Url::to('@hdomain'));
        $I->see('Domains', 'h1');
        $I->see('Create domain', 'a');
        $this->ensureICanSeeAdvancedSearchBox();
        $this->ensureICanSeeLegendBox();
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox()
    {
        $this->index->containsFilters([
            new Input('Domain name'),
            new Input('Domain list (comma-separated)'),
            new Input('IP'),
            new Select2('Status'),
            new Select2('Show aliases only'),
            new Select2('Client'),
            new Select2('Reseller'),
            new Select2('Server'),
        ]);
    }

    private function ensureICanSeeLegendBox()
    {
        $this->index->containsLegend([
            'Domain',
            'DNS records',
            'Alias',
            'Name server',
            'Complex domain',
        ]);
    }

    private function ensureICanSeeBulkSearchBox()
    {
        $this->index->containsBulkButtons([
            'Delete',
        ]);
        $this->index->containsColumns([
            'Domain name',
            'Client',
            'Reseller',
            'Account',
            'Server',
            'Status',
            'IP',
            'Service',
        ]);
    }
}
