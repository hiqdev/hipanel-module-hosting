<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hiqdev\combo\StaticCombo;

?>

<div class="col-md-6">
    <?= $search->field('login_like') ?>
    <?= $search->field('state')->widget(StaticCombo::classname(), [
        'data' => $state_data,
        'hasId' => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => true,
            ]
        ],
    ]) ?>

</div>

<div class="col-md-6">
    <?= $search->field('client_id')->widget(ClientCombo::classname()) ?>
    <?= $search->field('seller_id')->widget(ClientCombo::classname()) ?>
</div>


