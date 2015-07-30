<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\grid;

use hipanel\grid\DataColumn;
use hipanel\modules\hosting\widgets\combo\AccountCombo;
use hipanel\widgets\Select2;
use yii\helpers\Url;
use yii\helpers\Html;

use yii\web\JsExpression;

class AccountColumn extends DataColumn
{
    public $attribute = 'account_id';

    public $nameAttribute = 'account';

    public $format = 'html';

    public function init () {
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
            };
        };
    }
}
