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
                            <div class="form-instance" xmlns="http://www.w3.org/1999/html"
                                 xmlns="http://www.w3.org/1999/html">
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
                                echo $form->field($model, "[$i]vhost_id")->widget(VhostCombo::class, ['formElementSelector' => '.form-instance']);

                                $model->alias_type = 'subdomain';
                                echo $form->field($model, "[$i]alias_type")->radio([
                                    'value' => 'subdomain',
                                    'class' => 'alias-type',
                                    'label' => Yii::t('hipanel:hosting', 'Subdomain of existing domain'),
                                ]);
                                echo $form->field($model, "[$i]alias_type")->radio([
                                    'id' => $model->formName() . '-' . $i . '-alias_type-new',
                                    'value' => 'new',
                                    'class' => 'alias-type',
                                    'label' => Yii::t('hipanel:hosting', 'New domain'),
                                ]);
                                ?>

                                <div class="alias-subdomain form-inline">
                                    <?= $form->field($model, "[$i]subdomain")->input('text', ['data-attribute' => 'subdomain'])->label(false) ?>
                                    <?= Html::tag('span', '.') ?>
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
    $(this).on('change', '.alias-type', function (e) {
        var $form = $(this).closest('.form-instance');

        var $sub_inputs = $form.find('.alias-subdomain, input[data-attribute="subdomain"], input[data-attribute="sub-with-domain"]');
        var $new_inputs = $form.find('.alias-newdomain, input[data-attribute="domain"]');

        if ($(this).attr('value') == 'subdomain') {
            $sub_inputs.show().prop('disabled', false);
            $new_inputs.prop('disabled', true).hide();
        } else {
            $sub_inputs.hide().prop('disabled', true);
            $new_inputs.prop('disabled', false).show();
        }
    });

    $('#dynamic-form').on('update', 'input[data-attribute="sub-with-domain"]', function (event) {
        var $form = $(this).closest('.form-instance');
        var subdomain = $form.find('input[data-attribute="subdomain"]').val();
        var domain = $form.find('input[data-attribute="dns_hdomain_id"]').select2('data');
        var value = '';

        if (domain && domain.text) {
            value = (subdomain.length > 0 ? (subdomain + '.') : '') + domain.text;
        }
        $(this).val(value).trigger('change');
    });

    $('#dynamic-form').on('change', 'input[data-attribute="subdomain"]', function () {
        var $form = $(this).closest('.form-instance');
        $form.find('input[data-attribute="sub-with-domain"]').trigger('update');
    });
JS
);
