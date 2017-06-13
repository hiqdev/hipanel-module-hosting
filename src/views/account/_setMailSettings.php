<?php

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

    <div class="row">
        <div class="col-md-6">
            <fieldset>
                <legend><?= Yii::t('hipanel:hosting', 'Enter mail settings') ?></legend>
                <?= Html::activeHiddenInput($model, "[$model->id]id") ?>
                <?= $form->field($model, "[$model->id]per_hour_limit") ?>
                <?= $form->field($model, "[$model->id]block_send")->checkbox() ?>
            </fieldset>
        </div>
    </div>
    <!-- /.row -->
    <hr>
    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?> &nbsp;
    <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
<?php $form::end() ?>
