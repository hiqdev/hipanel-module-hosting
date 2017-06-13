<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="callout callout-warning">
    <h4><?= Yii::t('hipanel:hosting', 'This will immediately terminate all sessions of the user!') ?></h4>
</div>

<div class="callout callout-default">
    <?= Yii::t('hipanel:client', 'Enter comma separated list of IP-addresses or subnets.') ?><br>
    <?= Yii::t('hipanel', 'Example') ?>: 88.208.52.222, 213.174.0.0/16<br><br>
    <?= Yii::t('hipanel:client', 'Your current IP address is {ip}', ['ip' => Yii::$app->request->getUserIp()]) ?><br>
</div>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => $model->scenario . '-form',
    ],
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]) ?>

    <?= Html::activeHiddenInput($model, "[$model->id]id") ?>
    <?= $form->field($model, "[$model->id]sshftp_ips") ?>
    <?= Html::activeHiddenInput($model, "[$model->id]login") ?>

    <hr>
    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?> &nbsp;
    <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>

<?php $form::end() ?>
