<?php

use hipanel\widgets\AdvancedSearch;
use yii\web\View;

/**
 * @var AdvancedSearch $search
 * @var $this View
 */
?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('ip') ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('tags')->dropDownList($search->model->getTagOptions(), ['prompt' => $search->model->getAttributeLabel('tags')]) ?>
</div>
