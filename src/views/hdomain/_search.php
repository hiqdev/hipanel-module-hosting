<?php
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\client\widgets\combo\SellerCombo;
use hipanel\modules\server\widgets\combo\PanelServerCombo;
use hiqdev\combo\StaticCombo;

/**
 * @var \hipanel\widgets\AdvancedSearch $search
 * @var array $stateData
 * @var array $typeData
 */
?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?php /// TODO: line below - `implode` should be replaced with something more architectural ?>
    <?= $search->field('domain_in')->input('text', ['value' => implode(',', $search->model->domain_in)])->label(Yii::t('app', 'Domain')) ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('domain_like')->label(Yii::t('app', 'Domain (partial match)')) ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('ip') ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('state')->widget(StaticCombo::class, [
        'data' => $stateData,
        'hasId' => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => false,
            ]
        ],
    ]) ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('show_aliases_only')->widget(StaticCombo::class, [
        'data' => $typeData,
        'hasId' => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => false,
            ]
        ],
    ])->label(Yii::t('app', 'Type')); ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('client_id')->widget(ClientCombo::class, ['formElementSelector' => '.form-group']) ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('seller_id')->widget(SellerCombo::class, ['formElementSelector' => '.form-group']) ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('server')->widget(PanelServerCombo::class, ['formElementSelector' => '.form-group']) ?>
</div>
