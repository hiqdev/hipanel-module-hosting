<?php
use hipanel\widgets\ModalButton;
use hipanel\widgets\PasswordInput;
use yii\helpers\Html;

?>

<?php

$modalButton = ModalButton::begin([
    'model' => $model,
    'scenario' => 'set-password',
    'button' => [
        'label' => '<i class="fa fa-fw fa-lock"></i> ' . Yii::t('hipanel', 'Change password'),
    ],
    'modal' => [
        'header' => Html::tag('h4', Yii::t('hipanel', 'New password')),
        'headerOptions' => ['class' => 'label-warning'],
        'footer' => [
            'label' => Yii::t('hipanel', 'Change password'),
            'data-loading-text' => Yii::t('hipanel', 'Changing...'),
            'class' => 'btn btn-warning',
        ],
    ],
]);
?>

<?php echo $modalButton->form->field($model, 'password')->widget(PasswordInput::class)->label(false);

ModalButton::end();
