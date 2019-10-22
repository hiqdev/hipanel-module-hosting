<?php

/**
 * @var \yii\web\View $this
 * @var \hipanel\modules\hosting\models\Account $model
 */

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\widgets\combo\SshAccountCombo;
use hipanel\modules\server\widgets\combo\PanelServerCombo;
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
                <?php if (Yii::$app->user->can('support')) : ?>
                    <?= $form->field($model, "[$model->id]client")->widget(ClientCombo::class, ['inputOptions' => ['readonly' => true]]) ?>
                <?php endif ?>
                <?= $form->field($model, "[$model->id]server")->widget(PanelServerCombo::class, ['inputOptions' => ['readonly' => true]]) ?>
                <?= $form->field($model, "[$model->id]login")->widget(SshAccountCombo::class, ['inputOptions' => ['readonly' => true]]) ?>
                <?= Html::activeHiddenInput($model->values, "id") ?>
                <?= $form->field($model->values, "per_hour_limit") ?>
                <?= $form->field($model->values, "block_send")->checkbox() ?>
            </fieldset>
        </div>
    </div>
    <hr>
    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?> &nbsp;
    <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
<?php $form::end() ?>
