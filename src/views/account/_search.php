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
    <?= $search->field('login_like') ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('server')->widget(PanelServerCombo::className(), ['formElementSelector' => '.form-group']) ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('state')->widget(StaticCombo::classname(), [
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
    <?= $search->field('client_id')->widget(ClientCombo::classname(), ['formElementSelector' => '.form-group']) ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('seller_id')->widget(SellerCombo::classname(), ['formElementSelector' => '.form-group']) ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('type')->widget(StaticCombo::classname(), [
        'data' => $typeData,
        'hasId' => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => false,
            ]
        ],
    ]) ?>
</div>


