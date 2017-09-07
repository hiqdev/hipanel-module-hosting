<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;

$form = ActiveForm::begin([
    'id' => 'dynamic-form',
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]);

?>

    <div class="row">
        <div class="col-md-4">
            <div class="box box-widget">
                <div class="box-body">
                    <?= Html::activeHiddenInput($model, 'id') ?>
                    <?= $form->field($model, 'type')->dropDownList($typeOptions) ?>
                    <?= $form->field($model, 'method')->dropDownList($methodOptions) ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'day')->dropDownList($dayOptions, ['prompt' => '--']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'hour')->dropDownList($hourOptions, ['prompt' => '--']) ?>
                        </div>
                    </div>
                    <?= $form->field($model, 'path') ?>
                    <?= $form->field($model, 'include')->textarea() ?>
                    <?= $form->field($model, 'exclude')->textarea() ?>
                    <?= $form->field($model, 'skip_lock')->checkbox() ?>
                </div>
            </div>
        </div>
    </div>


<?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?>
    &nbsp;
<?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>

<?php ActiveForm::end();
