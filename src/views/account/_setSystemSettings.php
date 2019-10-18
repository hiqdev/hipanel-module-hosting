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

    <div class="row">
        <div class="col-md-6">
            <fieldset>
                <legend><?= Yii::t('hipanel:hosting', 'Enter system settings') ?></legend>
                <?= Html::activeHiddenInput($model, "[$model->id]id") ?>
                <?= $form->field($model, "[$model->id]path") ?>
                <?= $form->field($model, "[$model->id]gid") ?>
                <?= $form->field($model, "[$model->id]uid") ?>
            </fieldset>
        </div>
    </div>
    <hr>
    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?> &nbsp;
    <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
<?php $form::end() ?>
