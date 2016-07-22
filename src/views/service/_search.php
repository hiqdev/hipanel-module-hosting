<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\client\widgets\combo\SellerCombo;
use hipanel\modules\server\widgets\combo\PanelServerCombo;
use hipanel\modules\server\widgets\combo\ServerCombo;
use hiqdev\combo\StaticCombo;

/**
 * @var $stateData array
 * @var $softData array
 * @var \hipanel\widgets\AdvancedSearch $search
 */

?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('name_like') ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('server')->widget(ServerCombo::class, ['formElementSelector' => '.form-group']) ?>
</div>

<?php if (Yii::$app->user->can('support')) { ?>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('client_id')->widget(ClientCombo::class, ['formElementSelector' => '.form-group']) ?>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('seller_id')->widget(SellerCombo::class, ['formElementSelector' => '.form-group']) ?>
    </div>
<?php } ?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('soft')->widget(StaticCombo::class, [
        'data' => $softData,
        'hasId' => true,
        'multiple' => false,
    ]) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('state')->widget(StaticCombo::class, [
        'data' => $stateData,
        'hasId' => true,
        'multiple' => false,
    ]) ?>
</div>
