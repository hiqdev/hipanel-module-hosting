<?php

namespace hipanel\modules\hosting\tests\acceptance\client;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Step\Acceptance\Client;

class DomainsCest
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
        $I->needPage(Url::to('@hdomain'));
        $I->see('Domains', 'h1');
        $this->ensureICanSeeAdvancedSearchBox($I);
        $this->ensureICanSeeLegendBox($I);
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox(Client $I)
    {
        $I->see('Create domain', 'a');
        $I->see('Advanced search', 'h3');

        $formId = 'form-advancedsearch-hdomain-search';
        $this->index->containsFilters($formId, [
            ['input' => [
                'id' => 'hdomainsearch-domain_like',
                'placeholder' => 'Domain name',
            ]],
            ['input' => [
                'id' => 'hdomainsearch-domain_in',
            ]],
            ['input' => [
                'id' => 'hdomainsearch-ip',
                'placeholder' => 'IP',
            ]],
        ]);

        $I->see('Status', "//form[@id='$formId']//span");
        $I->see('Show aliases only', "//form[@id='$formId']//span");
        $I->see('Server', "//form[@id='$formId']//span");
        $I->see('Domain name', "//form[@id='$formId']//label");
        $I->see('Domain list (comma-separated)', "//form[@id='$formId']//label");
        $I->see('Type', "//form[@id='$formId']//label");
    }

    private function ensureICanSeeLegendBox(Client $I)
    {
        $I->see('Legend', 'h3');

        $legend = [
            'Domain',
            'DNS records',
            'Alias',
            'Name server',
            'Complex domain',
        ];
        foreach ($legend as $text) {
            $I->see($text, '//ul/li');
        }
    }

    private function ensureICanSeeBulkSearchBox()
    {
        $this->index->containsBulkButtons([
            ["//button[@type='submit']" => 'Delete'],
        ]);
        $this->index->containsColumns('bulk-hdomain-search', [
            'Domain name',
            'Account',
            'Server',
            'Status',
            'IP',
            'Service',
        ]);
    }
}
