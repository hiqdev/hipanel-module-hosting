<?php

/* @var $this View */
/* @var $model hipanel\modules\hosting\models\Vhost */
/* @var $type string */

use hipanel\base\View;
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\widgets\combo\SshAccountCombo;
use hipanel\modules\server\widgets\combo\ServerCombo;
use hiqdev\combo\StaticCombo;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$form = ActiveForm::begin([
    'id'                     => 'dynamic-form',
    'enableClientValidation' => true,
    'validateOnBlur'         => true,
    'enableAjaxValidation'   => true,
    'validationUrl'          => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]); ?>

    <div class="container-items">
        <?php foreach ($models as $i => $model) { ?>
            <div class="row">
                <div class="col-md-9">
                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="form-instance" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
                                <?= $form->field($model, "[$i]id")->hiddenInput()->label(false) ?>

                                <div class="row">
                                    <div class="col-md-4">
                                        <?= $form->field($model, "[$i]client")->widget(ClientCombo::className(), ['formElementSelector' => '.form-instance', 'inputOptions' => ['readonly' => true]]) ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?= $form->field($model, "[$i]server")->widget(ServerCombo::className(), ['formElementSelector' => '.form-instance', 'inputOptions' => ['readonly' => true]]) ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?= $form->field($model, "[$i]account")->widget(SshAccountCombo::className(), [
                                            'formElementSelector' => '.form-instance',
                                            'inputOptions'        => [
                                                'data-field' => 'account',
                                                'readonly' => true
                                            ],
                                        ]) ?>
                                    </div>
                                </div>
                                <?php
                                print $form->field($model, "[$i]domain")->input('text', ['readonly' => true]);
                                print $form->field($model, "[$i]docroot")->input('text', ['readonly' => true]);
                                ?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <?= $form->field($model, "[$i]port") ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($model, "[$i]domain_prefix") ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($model, "[$i]docroot_postfix") ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($model, "[$i]cgibin_postfix"); ?>
                                    </div>
                                </div>
                                <?php
                                print $form->field($model, "[$i]enable_accesslog")->checkbox();
                                print $form->field($model, "[$i]enable_errorslog")->checkbox();
                                print $form->field($model, "[$i]enable_suexec")->checkbox();
                                print $form->field($model, "[$i]enable_ssi")->checkbox();
                                print $form->field($model, "[$i]enable_scripts")->checkbox();

                                print $form->field($model, "[$i]apache_conf")->textarea(['rows' => 8]);
                                print $form->field($model, "[$i]nginx_conf")->textarea(['rows' => 8]);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-default']) ?>
    &nbsp;
<?= Html::button(Yii::t('app', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>
<?php ActiveForm::end();

//$this->registerJs("$('#hdomain-proxy_enable').trigger('change');");
