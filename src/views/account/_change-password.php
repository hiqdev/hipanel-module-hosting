<?php
use hipanel\widgets\ModalButton;
use hipanel\widgets\PasswordInput;
use yii\helpers\Html;

?>
<?php $modalButton = ModalButton::begin([
    'model' => $model,
    'scenario' => 'set-password',
    'button' => [
        'label' => '<i class="fa fa-lock"></i>' . Yii::t('hipanel', 'Change password'),
        'disabled' => !$model->isOperable(),
    ],
    'modal' => [
        'header' => Html::tag('h4', Yii::t('hipanel:hosting', 'Enter a new password')),
        'headerOptions' => ['class' => 'label-info'],
        'footer' => [
            'label' => Yii::t('hipanel', 'Change'),
            'data-loading-text' => Yii::t('hipanel', 'Changing...'),
            'class' => 'btn btn-warning',
        ]
    ]
]) ?>
<div class="callout callout-warning">
    <h4><?= Yii::t('hipanel:hosting', 'This will immediately terminate all sessions of the user!') ?></h4>
</div>

<?= $modalButton->form->field($model, 'password')->widget(PasswordInput::class)->label(false) ?>
<?= Html::activeHiddenInput($model, 'login') ?>
<?php ModalButton::end() ?>
