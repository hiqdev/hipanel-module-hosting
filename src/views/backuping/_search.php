<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\widgets\combo\AccountCombo;
use hipanel\modules\server\widgets\combo\PanelServerCombo;
use hiqdev\combo\StaticCombo;

/**
 * @var \hipanel\widgets\AdvancedSearch $search
 * @var array $stateOptions
 */
?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('state')->widget(StaticCombo::classname(), [
        'data' => $stateOptions,
        'hasId' => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => false,
            ],
        ],
    ]) ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('account')->widget(AccountCombo::className()) ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('server')->widget(PanelServerCombo::className(), ['formElementSelector' => '.form-group']) ?>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('client_id')->widget(ClientCombo::classname(), ['formElementSelector' => '.form-group']) ?>
</div>
