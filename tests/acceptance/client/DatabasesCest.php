<?php

namespace hipanel\modules\hosting\tests\acceptance\client;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Step\Acceptance\Client;

class DatabasesCest
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
        $I->needPage(Url::to('@db'));
        $I->see('Databases', 'h1');
        $this->ensureICanSeeAdvancedSearchBox($I);
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox(Client $I)
    {
        $I->seeLink('Create DB', Url::to('create'));
        $I->see('Advanced search', 'h3');

        $formId = 'form-advancedsearch-db-search';
        $this->index->containsFilters($formId, [
            ['input' => [
                'id' => 'dbsearch-name',
                'placeholder' => 'DB name',
            ]],
            ['input' => [
                'id' => 'dbsearch-description',
                'placeholder' => 'Description',
            ]],
            ['input' => [
                'placeholder' => 'Status',
            ]],
        ]);

        $I->see('Server', "//form[@id='$formId']//span");
    }

    private function ensureICanSeeBulkSearchBox()
    {
        $this->index->containsBulkButtons([
            ["//button[@type='submit']" => 'Delete'],
        ]);
        $this->index->containsColumns('bulk-db-search', [
            'DB name',
            'Account',
            'Server',
            'Description',
            'Status',
        ]);
    }
}
