<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\widgets\combo\AccountCombo;
use hipanel\modules\server\widgets\combo\ServerCombo;
use hiqdev\combo\StaticCombo;
?>


<div class="col-md-4">
    <?= $search->field('server')->widget(ServerCombo::className(), ['formElementSelector' => '.form-group']) ?>
    <?= $search->field('account')->widget(AccountCombo::className()) ?>
</div>

<div class="col-md-4">
    <?= $search->field('state')->widget(StaticCombo::classname(), [
        'data' => $stateOptions,
        'hasId' => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => false,
            ]
        ],
    ]) ?>
    <?= $search->field('classes')->widget(StaticCombo::classname(), [
        'data' => $objectOptions,
        'hasId' => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => false,
            ]
        ],
    ]) ?>
</div>
<!-- /.col-md-4 -->
<div class="col-md-4">
    <?= $search->field('client_id')->widget(ClientCombo::classname(), ['formElementSelector' => '.form-group']) ?>
    <?= $search->field('type_ids')->widget(StaticCombo::classname(), [
        'data' => $typeOptions,
        'hasId' => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => true,
            ]
        ],
    ]) ?>
</div>
<!-- /.com-md-4 -->
