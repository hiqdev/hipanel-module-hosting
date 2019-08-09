<?php

use hipanel\widgets\ModalButton;
use hipanel\widgets\PasswordInput;
use yii\helpers\Html;

?>

<?php $modalButton = ModalButton::begin([
    'model' => $model,
    'scenario' => 'set-password',
    'button' => [
        'label' => '<i class="fa fa-fw fa-lock"></i>' . Yii::t('hipanel', 'Change password'),
    ],
    'modal' => [
        'header' => Html::tag('h4', Yii::t('hipanel', 'New password')),
        'headerOptions' => ['class' => 'label-warning'],
        'footer' => [
            'label' => Yii::t('hipanel', 'Change'),
            'data-loading-text' => Yii::t('hipanel', 'Changing...'),
            'class' => 'btn btn-warning',
        ],
    ],
]) ?>

<p class="text-bold">
    <?= Yii::t('hipanel', 'This will immediately terminate all sessions of the user!') ?>
</p>

<?= $modalButton->form->field($model, 'password')->widget(PasswordInput::class, [
    'randomOptions' => [
        'weak' => ['label' => Yii::t('hipanel', 'Weak'), 'length' => 8, 'specialchars' => 1],
        'medium' => ['label' => Yii::t('hipanel', 'Medium'), 'length' => 10, 'specialchars' => 1],
        'strong' => ['label' => Yii::t('hipanel', 'Strong'), 'length' => 14, 'specialchars' => 1],
    ],
])->label(false) ?>
<?php ModalButton::end() ?>
