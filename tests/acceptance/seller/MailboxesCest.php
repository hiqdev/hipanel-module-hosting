<?php

namespace hipanel\modules\hosting\tests\acceptance\seller;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Step\Acceptance\Seller;

class MailboxesCest
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
        $I->needPage(Url::to('@mail'));
        $I->see('Mailboxes', 'h1');
        $I->seeLink('Create mailbox', Url::to('create'));
        $this->ensureICanSeeAdvancedSearchBox($I);
        $this->ensureICanSeeLegendBox();
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox(Seller $I)
    {
        $this->index->containsFilters([
            Input::asAdvancedSearch($I, 'E-mail'),
            Select2::asAdvancedSearch($I, 'Server'),
            Select2::asAdvancedSearch($I, 'Status'),
            Select2::asAdvancedSearch($I, 'Client'),
            Select2::asAdvancedSearch($I, 'Reseller'),
            Select2::asAdvancedSearch($I, 'Type'),
        ]);
    }

    private function ensureICanSeeLegendBox()
    {
        $this->index->containsLegend([
            'Mail box',
            'Mail alias',
            'Mail box with aliases',
        ]);
    }

    private function ensureICanSeeBulkSearchBox()
    {
        $this->index->containsBulkButtons([
            'Enable',
            'Disable',
            'Delete',
        ]);
        $this->index->containsColumns( [
            'E-mail',
            'Type',
            'Forwarding',
            'Client',
            'Reseller',
            'Server',
            'Status',
        ]);
    }
}
