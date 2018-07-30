<?php

namespace hipanel\modules\hosting\tests\acceptance\client;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Step\Acceptance\Client;

class MailboxesCest
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
        $I->needPage(Url::to('@mail'));
        $I->see('Mailboxes', 'h1');
        $this->ensureICanSeeAdvancedSearchBox($I);
        $this->ensureICanSeeLegendBox($I);
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox(Client $I)
    {
        $I->seeLink('Create mailbox', Url::to('create'));
        $I->see('Advanced search', 'h3');

        $formId = 'form-advancedsearch-mail-search';
        $this->index->containsFilters($formId, [
            ['input' => [
                'id' => 'mailsearch-mail_like',
                'placeholder' => 'E-mail',
            ]],
        ]);

        $I->see('Server', "//form[@id='$formId']//span");
        $I->see('Status', "//form[@id='$formId']//span");
        $I->see('Type', "//form[@id='$formId']//span");
    }

    private function ensureICanSeeLegendBox(Client $I)
    {
        $I->see('Legend', 'h3');

        $legend = [
            'Mail box',
            'Mail alias',
            'Mail box with aliases',
        ];
        foreach ($legend as $text) {
            $I->see($text, '//ul/li');
        }
    }

    private function ensureICanSeeBulkSearchBox()
    {
        $this->index->containsBulkButtons([
            ["//button[@type='submit']" => 'Enable'],
            ["//button[@type='submit']" => 'Disable'],
            ["//button[@type='submit']" => 'Delete'],
        ]);
        $this->index->containsColumns('bulk-mail-search', [
            'E-mail',
            'Type',
            'Forwarding',
            'Server',
            'Status',
        ]);
    }
}
