<?php

namespace hipanel\modules\hosting\tests\acceptance\admin;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Step\Acceptance\Admin;

class ServicesCest
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
        $I->needPage(Url::to('@service'));
        $I->see('Services', 'h1');
        $this->ensureICanSeeAdvancedSearchBox();
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox()
    {
        $this->index->containsFilters([
            new Input('Name'),
            new Select2('Server'),
            new Select2('Client'),
            new Select2('Reseller'),
            new Select2('Soft'),
            new Select2('Status'),
        ]);
    }

    private function ensureICanSeeBulkSearchBox()
    {
        $this->index->containsColumns([
            'Reseller',
            'Client',
            'Server',
            'Object',
            'IP',
            'Soft',
            'Status',
        ]);
    }
}
