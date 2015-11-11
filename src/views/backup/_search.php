<?php

use hipanel\modules\client\widgets\combo\ClientCombo;

use hipanel\modules\hosting\widgets\combo\AccountCombo;
use hipanel\modules\server\widgets\combo\ServerCombo;
use hiqdev\combo\StaticCombo;

?>

<div class="col-md-6">
    <?= $search->field('db_like') ?>
    <?= $search->field('domain_like') ?>
    <?= $search->field('account')->widget(AccountCombo::className()) ?>
</div>

<div class="col-md-6">
    <?= $search->field('server')->widget(ServerCombo::className(), ['formElementSelector' => '.form-group']) ?>
    <?= $search->field('client_id')->widget(ClientCombo::classname(), ['formElementSelector' => '.form-group']) ?>
    <?= $search->field('classes')->widget(StaticCombo::classname(), [
        'data' => $objectOptions,
        'hasId' => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => false,
            ],
        ],
    ]) ?>
</div>