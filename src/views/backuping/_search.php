<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\widgets\combo\AccountCombo;
use hipanel\modules\server\widgets\combo\ServerCombo;
use hiqdev\combo\StaticCombo;

?>

<div class="col-md-6">
    <?= $search->field('state')->widget(StaticCombo::classname(), [
        'data' => $stateOptions,
        'hasId' => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => false,
            ],
        ],
    ]) ?>
    <?= $search->field('account')->widget(AccountCombo::className()) ?>
</div>

<div class="col-md-6">
    <?= $search->field('server')->widget(ServerCombo::className(), ['formElementSelector' => '.form-group']) ?>
    <?= $search->field('client_id')->widget(ClientCombo::classname(), ['formElementSelector' => '.form-group']) ?>
</div>