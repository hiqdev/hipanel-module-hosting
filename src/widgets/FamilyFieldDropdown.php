<?php

namespace hipanel\modules\hosting\widgets;

use hipanel\widgets\AdvancedSearch;
use Yii;
use yii\base\Widget;

class FamilyFieldDropdown extends Widget
{
    public AdvancedSearch $search;

    public function run()
    {
        return $this->search->field('family')->dropDownList([
            '4' => Yii::t('hipanel.hosting.ipam', 'IPv4'),
            '6' => Yii::t('hipanel.hosting.ipam', 'IPv6'),
        ], ['prompt' => $this->search->model->getAttributeLabel('family')]);
    }
}
