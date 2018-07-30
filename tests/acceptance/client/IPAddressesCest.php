<?php

namespace hipanel\modules\hosting\tests\acceptance\client;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Step\Acceptance\Client;

class IPAddressesCest
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
        $I->needPage(Url::to('@ip'));
        $I->see('IP addresses', 'h1');
        $this->ensureICanSeeAdvancedSearchBox($I);
        $this->ensureICanSeeLegendBox($I);
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox(Client $I)
    {
        $I->see('Advanced search', 'h3');

        $formId = 'form-advancedsearch-ip-search';
        $this->index->containsFilters($formId, [
            ['input' => [
                'id' => 'ipsearch-ip_like',
                'placeholder' => 'IP',
            ]],
            ['input' => [
                'placeholder' => 'Tags',
            ]],
        ]);

        $I->see('Servers', "//form[@id='$formId']//span");
    }

    private function ensureICanSeeLegendBox(Client $I)
    {
        $I->see('Legend', 'h3');

        $legend = [
            'Shared',
            'Free',
            'Dedicated',
            'System',
            'Blocked',
        ];
        foreach ($legend as $text) {
            $I->see($text, '//ul/li');
        }
    }

    private function ensureICanSeeBulkSearchBox()
    {
        $this->index->containsColumns('bulk-ip-search', [
            'IP',
            'Counters',
            'Links',
        ]);
    }
}
