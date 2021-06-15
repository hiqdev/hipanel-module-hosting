<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\tests\acceptance\client;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Step\Acceptance\Client;
use Yii;

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
        if (!Yii::$app->params['module.hosting.is_public']) {
            $I->markTestSkipped('Test is not allowed for client');
        }
        $I->login();
        $I->needPage(Url::to('@hdomain'));
        $I->see('Domains', 'h1');
        $I->see('Create domain', 'a');
        $this->ensureICanSeeAdvancedSearchBox($I);
        $this->ensureICanSeeLegendBox();
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox(Client $I)
    {
        $this->index->containsFilters([
            Input::asAdvancedSearch($I, 'Domain name'),
            Input::asAdvancedSearch($I, 'Domain list (comma-separated)'),
            Input::asAdvancedSearch($I, 'IP'),
            Select2::asAdvancedSearch($I, 'Status'),
            Select2::asAdvancedSearch($I, 'Show aliases only'),
            Select2::asAdvancedSearch($I, 'Server'),
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
            'Account',
            'Server',
            'Status',
            'IP',
            'Service',
        ]);
    }
}
