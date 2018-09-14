<?php

namespace hipanel\modules\hosting\tests\acceptance\client;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;
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
        $I->see('Create account', 'a');
        $this->ensureICanSeeAdvancedSearchBox($I);
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox(Client $I)
    {
        $this->index->containsFilters([
            Input::asAdvancedSearch($I, 'Login'),
            Select2::asAdvancedSearch($I, 'Server'),
            Select2::asAdvancedSearch($I, 'Type'),
            Select2::asAdvancedSearch($I, 'Status'),
        ]);
    }

    private function ensureICanSeeBulkSearchBox()
    {
        $this->index->containsBulkButtons([
            'Basic actions',
        ]);
        $this->index->containsColumns([
            'Account',
            'Server',
            'Status',
            'Type',
        ]);
    }
}
