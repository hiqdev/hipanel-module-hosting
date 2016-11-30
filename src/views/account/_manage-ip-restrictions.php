<?php

use hipanel\widgets\ModalButton;
use yii\helpers\Html;

?>

<?php $modalButton = ModalButton::begin([
    'model' => $model,
    'scenario' => 'set-allowed-ips',
    'button' => [
        'label' => '<i class="fa fa-globe"></i>' . Yii::t('hipanel:hosting', 'Manage IP restrictions'),
        'disabled' => !$model->isOperable(),
    ],
    'modal' => [
        'header' => Html::tag('h4', Yii::t('hipanel:hosting', 'Enter new restrictions')),
        'headerOptions' => ['class' => 'label-info'],
        'footer' => [
            'label' => Yii::t('hipanel', 'Change'),
            'data-loading-text' => Yii::t('hipanel', 'Changing...'),
            'class' => 'btn btn-warning',
        ]
    ],
    'form' => [
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'validationUrl' => ['single-validate-form', 'scenario' => 'set-allowed-ips']
    ],
]) ?>
<div class="callout callout-warning">
    <h4><?= Yii::t('hipanel:hosting', 'This will immediately terminate all sessions of the user!') ?></h4>
</div>

<?= $modalButton->form->field($model, 'sshftp_ips') ?>
<?= Html::activeHiddenInput($model, 'login') ?>
<?php ModalButton::end() ?>
