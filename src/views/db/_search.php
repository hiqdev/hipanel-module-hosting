<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\client\widgets\combo\SellerCombo;
use hipanel\modules\server\widgets\combo\PanelServerCombo;
use hiqdev\combo\StaticCombo;

/**
 * @var \hipanel\widgets\AdvancedSearch $search
 * @var array $stateData
 */
?>

<div class="col-md-6">
    <?= $search->field('name') ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('server')->widget(PanelServerCombo::class, ['formElementSelector' => '.form-group']) ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('description') ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('client_id')->widget(ClientCombo::class, ['formElementSelector' => '.form-group']) ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('seller_id')->widget(SellerCombo::class, ['formElementSelector' => '.form-group']) ?>
</div>
<div class="col-md-6">
    <?= $search->field('state')->widget(StaticCombo::class, [
        'data' => $stateData,
        'hasId' => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => true,
            ]
        ],
    ]) ?>
</div>
