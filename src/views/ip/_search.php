<?php

use hiqdev\combo\StaticCombo;
use yii\web\View;

/**
 * @var \hipanel\widgets\AdvancedSearch $search
 * @var $this View
 * @var $ipTags array
 */
?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('ips')->label(Yii::t('hipanel:hosting', 'IP')) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('server_inilike') ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('tag_in')->widget(StaticCombo::class, [
        'data' => $ipTags,
        'hasId' => true,
        'multiple' => true,
    ]) ?>
</div>
