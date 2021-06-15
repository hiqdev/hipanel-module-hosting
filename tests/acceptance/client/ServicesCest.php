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
        if (!Yii::$app->params['module.hosting.is_public']) {
            $I->markTestSkipped('Test is not allowed for client');
        }
        $I->login();
        $I->needPage(Url::to('@service'));
        $I->see('Services', 'h1');
        $this->ensureICanSeeAdvancedSearchBox($I);
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox(Client $I)
    {
        $this->index->containsFilters([
            Input::asAdvancedSearch($I, 'Name'),
            Select2::asAdvancedSearch($I, 'Server'),
            Select2::asAdvancedSearch($I, 'Soft'),
            Select2::asAdvancedSearch($I, 'Status'),
        ]);
    }

    private function ensureICanSeeBulkSearchBox()
    {
        $this->index->containsColumns([
            'Server',
            'Object',
            'IP',
            'Soft',
            'Status',
        ]);
    }
}
