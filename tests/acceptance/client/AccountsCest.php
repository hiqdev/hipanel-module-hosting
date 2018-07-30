<?php

namespace hipanel\modules\hosting\tests\acceptance\client;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Step\Acceptance\Client;

class AccountsCest
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
        $I->needPage(Url::to('@account'));
        $I->see('Accounts', 'h1');
        $this->ensureICanSeeAdvancedSearchBox($I);
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox(Client $I)
    {
        $I->see('Create account', 'a');
        $I->see('Advanced search', 'h3');

        $formId = 'form-advancedsearch-account-search';
        $this->index->containsFilters($formId, [
            ['input' => [
                'id' => 'accountsearch-login_like',
                'placeholder' => 'Login',
            ]],
        ]);

        $I->see('Server', "//form[@id='$formId']//span");
        $I->see('Type', "//form[@id='$formId']//span");
        $I->see('Status', "//form[@id='$formId']//span");
    }

    private function ensureICanSeeBulkSearchBox()
    {
        $this->index->containsBulkButtons([
            ["//button[@type='button']" => 'Basic actions'],
        ]);
        $this->index->containsColumns('bulk-account-search', [
            'Account',
            'Server',
            'Status',
            'Type',
        ]);
    }
}
