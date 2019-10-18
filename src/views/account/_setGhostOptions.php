<?php

/**
 * @var \hipanel\modules\hosting\models\Account $model
 * @var \yii\web\View $this
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'sgo-form',
    ],
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-sgo-form', 'scenario' => $model->scenario]),
]) ?>
    <div class="row-md-6">
            <legend><?= Yii::t('hipanel:hosting:account', 'Enter global vhost options') ?></legend>
            <?= Html::activeHiddenInput($model->values, "id") ?>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model->values, "port") ?>
                    <?= $form->field($model->values, "global_apache_conf") ?>
                    <?= $form->field($model->values, "global_nginx_conf") ?>
                    <?= $form->field($model->values, "apache_conf") ?>
                    <?= $form->field($model->values, "nginx_conf") ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model->values, "nginx_listen") ?>
                    <?= $form->field($model->values, "domain_prefix") ?>
                    <?= $form->field($model->values, "docroot_postfix") ?>
                    <?= $form->field($model->values, "cgibin_postfix") ?>
                </div>
            </div>
            <?= $form->field($model->values, "no_suexec")->checkbox() ?>
            <?= $form->field($model->values, "allow_scripts")->checkbox() ?>
            <?= $form->field($model->values, "dont_enable_ssi")->checkbox() ?>
    </div>
    <hr>
    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?> &nbsp;
    <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
<?php $form::end() ?>
