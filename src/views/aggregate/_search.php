<?php

use hipanel\modules\hosting\widgets\FamilyFieldDropdown;
use hipanel\widgets\AdvancedSearch;
use yii\web\View;

/**
 * @var AdvancedSearch $search
 * @var $this View
 */
?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('ip_like') ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('rir')->dropDownList($this->context->getRefs('type,ip_rir', 'hipanel.hosting.ipam'), ['prompt' => $search->model->getAttributeLabel('rir')]) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= FamilyFieldDropdown::widget(['search' => $search]) ?>
</div>
