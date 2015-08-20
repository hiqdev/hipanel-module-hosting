<?php
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\client\widgets\combo\SellerCombo;
use hipanel\modules\server\widgets\combo\ServerCombo;
use hiqdev\combo\StaticCombo;

?>

<div class="col-md-6">
    <?php /// TODO: line below - `implode` should be replaced with something more architectural ?>
    <?= $search->field('domain_in')->input('text', ['value' => implode(',', $search->model->domain_in)])->label(Yii::t('app', 'Domain')) ?>
    <?= $search->field('domain_like')->label(Yii::t('app', 'Domain (partial match)')) ?>
    <?= $search->field('ip') ?>
    <?= $search->field('state')->widget(StaticCombo::classname(), [
        'data' => $stateData,
        'hasId' => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => false,
            ]
        ],
    ]) ?>
    <?= $search->field('show_aliases_only')->widget(StaticCombo::classname(), [
        'data' => $typeData,
        'hasId' => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => false,
            ]
        ],
    ])->label(Yii::t('app', 'Type')); ?>
</div>

<div class="col-md-6">
    <?= $search->field('client_id')->widget(ClientCombo::classname(), ['formElementSelector' => '.form-group']) ?>
    <?= $search->field('seller_id')->widget(SellerCombo::classname(), ['formElementSelector' => '.form-group']) ?>
    <?= $search->field('server')->widget(ServerCombo::className(), ['formElementSelector' => '.form-group']) ?>

</div>
