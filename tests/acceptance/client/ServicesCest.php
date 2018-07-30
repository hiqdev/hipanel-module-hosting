<?php

namespace hipanel\modules\hosting\tests\acceptance\client;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Step\Acceptance\Client;

class ServicesCest
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
        $I->needPage(Url::to('@service'));
        $I->see('Services', 'h1');
        $this->ensureICanSeeAdvancedSearchBox($I);
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox(Client $I)
    {
        $I->see('Advanced search', 'h3');

        $formId = 'form-advancedsearch-service-search';
        $this->index->containsFilters($formId, [
            ['input' => [
                'id' => 'servicesearch-name_like',
                'placeholder' => 'Name',
            ]],
        ]);

        $I->see('Server', "//form[@id='$formId']//span");
        $I->see('Soft', "//form[@id='$formId']//span");
        $I->see('Status', "//form[@id='$formId']//span");
    }

    private function ensureICanSeeBulkSearchBox()
    {
        $this->index->containsColumns('bulk-service-search', [
            'Server',
            'Object',
            'IP',
            'Soft',
            'Status',
        ]);
    }
}
