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
        'id' => $model->scenario . '-form',
    ],
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]) ?>
    <div class="row-md-6">
            <legend><?= Yii::t('hipanel:hosting', 'Enter global vhost options') ?></legend>
            <?= Html::activeHiddenInput($model, "[$model->id]id") ?>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, "[$model->id]port") ?>
                    <?= $form->field($model, "[$model->id]global_apache_conf") ?>
                    <?= $form->field($model, "[$model->id]global_nginx_conf") ?>
                    <?= $form->field($model, "[$model->id]apache_conf") ?>
                    <?= $form->field($model, "[$model->id]nginx_conf") ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, "[$model->id]nginx_listen") ?>
                    <?= $form->field($model, "[$model->id]domain_prefix") ?>
                    <?= $form->field($model, "[$model->id]docroot_postfix") ?>
                    <?= $form->field($model, "[$model->id]cgibin_postfix") ?>
                </div>
            </div>
            <?= $form->field($model, "[$model->id]no_suexec")->checkbox() ?>
            <?= $form->field($model, "[$model->id]allow_scripts")->checkbox() ?>
            <?= $form->field($model, "[$model->id]dont_enable_ssi")->checkbox() ?>
    </div>
    <hr>
    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?> &nbsp;
    <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
<?php $form::end() ?>
