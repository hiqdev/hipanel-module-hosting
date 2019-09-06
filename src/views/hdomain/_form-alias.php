<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\widgets\combo\HdomainCombo;
use hipanel\modules\hosting\widgets\combo\SshAccountCombo;
use hipanel\modules\hosting\widgets\combo\VhostCombo;
use hipanel\modules\server\models\Server;
use hipanel\modules\server\widgets\combo\PanelServerCombo;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model hipanel\modules\hosting\models\Hdomain */
/* @var $type string */

$form = ActiveForm::begin([
    'id' => 'dynamic-form',
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]); ?>

    <div class="container-items">
        <?php foreach ($models as $i => $model) : ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="form-instance">
                                <?php
                                if (Yii::$app->user->can('support')) {
                                    echo $form->field($model, "[$i]client")->widget(ClientCombo::class, [
                                        'formElementSelector' => '.form-instance',
                                    ]);
                                }

                                echo $form->field($model, "[$i]server")->widget(PanelServerCombo::class, [
                                    'formElementSelector' => '.form-instance',
                                    'state' => Server::STATE_OK,
                                ]);
                                echo $form->field($model, "[$i]account")->widget(SshAccountCombo::class, [
                                    'formElementSelector' => '.form-instance',
                                    'inputOptions' => [
                                        'data-attribute' => 'account',
                                    ],
                                ]);
                                echo $form->field($model, "[$i]vhost_id")->widget(VhostCombo::class, ['hasId' => true, 'formElementSelector' => '.form-instance']);

                                echo $form->field($model, "[$i]alias_type")->radioList($model->getAliasTypeOptions(), ['class' => 'alias-type']);
                                ?>

                                <div class="alias-subdomain">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <?= $form->field($model, "[$i]subdomain")->input('text', ['data-attribute' => 'subdomain'])->label(false) ?>
                                        </div>
                                        <div class="col-md-8">
                                            <?= $form->field($model, "[$i]dns_hdomain_id")->widget(HdomainCombo::class, [
                                                'formElementSelector' => '.form-instance',
                                                'inputOptions' => [
                                                    'data-attribute' => 'dns_hdomain_id',
                                                ],
                                                'pluginOptions' => [
                                                    'onChange' => new JsExpression("function () {
                                                        $(this).closest('.form-instance').find('input[data-attribute=\"sub-with-domain\"]').trigger('update');
                                                    }
                                                "),
                                                ],
                                            ])->label(false) ?>
                                            <?= $form->field($model, "[$i]domain")->hiddenInput([
                                                'id' => $model->formName() . '-' . $i . '-domain-sub',
                                                'data-attribute' => 'sub-with-domain',
                                            ])->label(false) ?>
                                        </div>
                                    </div>

                                </div>
                                <div class="alias-newdomain">
                                    <?= $form->field($model, "[$i]domain")->input('text', [
                                        'data-attribute' => 'domain',
                                        'disabled' => true,
                                        'class' => 'form-control collapse',
                                    ])->label(false) ?>
                                </div>
                                <?= $form->field($model, "[$i]with_www")->checkbox() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
        <div class="row">
            <div class="col-md-4">
                <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?>
                &nbsp;
                <?= Html::button(Yii::t('hipanel', 'Cancel'), [
                    'class' => 'btn btn-default', 'onclick' => 'history.go(-1)',
                ]) ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end();

$this->registerJs(<<<'JS'
function handleAliasType(currentValue) {
    var $form = $('#dynamic-form').find('.form-instance');
    var $sub_inputs = $form.find('.alias-subdomain, input[data-attribute="subdomain"], input[data-attribute="sub-with-domain"]');
    var $new_inputs = $form.find('.alias-newdomain, input[data-attribute="domain"]');
    if (currentValue === 'subdomain') {
        $sub_inputs.prop('disabled', false).show();
        $new_inputs.prop('disabled', true).hide();
    } else if (currentValue === 'new')  {
        $sub_inputs.prop('disabled', true).hide();
        $new_inputs.prop('disabled', false).show();
    } else {
        $sub_inputs.prop('disabled', true).hide();
        $new_inputs.prop('disabled', true).hide();
    }
}

var initialAliasType = $(":input[name*=alias_type]:checked").val();
handleAliasType(initialAliasType);

$('#dynamic-form').on('change', '.alias-type', function (evt) {
    handleAliasType(evt.target.value);
});

$('#dynamic-form').on('update', 'input[data-attribute="sub-with-domain"]', function (evt) {
    var $form = $(this).closest('.form-instance');
    var subdomain = $form.find('input[data-attribute="subdomain"]').val();
    var domain = $form.find(':input[data-attribute="dns_hdomain_id"]').select2('data');
    var value = '';

    if (domain && domain.length && domain[0].text) {
        value = (subdomain.length > 0 ? (subdomain + '.') : '') + domain[0].text;
    }
    $(this).val(value).trigger('change');
});

$('#dynamic-form').on('change', 'input[data-attribute="subdomain"]', function (evt) {
    var $form = $(this).closest('.form-instance');
    $form.find('input[data-attribute="sub-with-domain"]').trigger('update');
});
JS
);
