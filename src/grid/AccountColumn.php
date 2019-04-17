<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\grid;

use hipanel\modules\hosting\widgets\combo\AccountCombo;
use hiqdev\higrid\DataColumn;
use yii\helpers\Html;

class AccountColumn extends DataColumn
{
    public $attribute = 'account_id';

    public $nameAttribute = 'account';

    public $format = 'html';

    public function init()
    {
        parent::init();

        if (!empty($this->grid->filterModel)) {
            if (!$this->filterInputOptions['id']) {
                $this->filterInputOptions['id'] = $this->attribute;
            }
            if (!$this->filter) {
                $this->filter = AccountCombo::widget([
                    'attribute'           => $this->attribute,
                    'model'               => $this->grid->filterModel,
                    'formElementSelector' => 'td',
                ]);
            }
        }
    }

    public function getDataCellValue($model, $key, $index)
    {
        return Html::a($model->{$this->nameAttribute}, ['@account/view', 'id' => $model->{$this->attribute}]);
    }
}
