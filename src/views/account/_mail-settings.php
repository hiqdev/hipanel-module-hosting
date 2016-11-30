<?php
use hipanel\widgets\ModalButton;
use yii\helpers\Html;

?>
<?php $modalButton = ModalButton::begin([
    'model' => $model,
    'scenario' => 'set-mail-settings',
    'button' => [
        'label' => '<i class="fa fa-envelope-o"></i>' . Yii::t('hipanel:hosting', 'Mail settings'),
        'disabled' => !$model->isOperable(),
    ],
    'modal' => [
        'header' => Html::tag('h4', Yii::t('hipanel:hosting', 'Enter mail settings')),
        'headerOptions' => ['class' => 'label-info'],
        'footer' => [
            'label' => Yii::t('hipanel', 'Change'),
            'data-loading-text' => Yii::t('hipanel', 'Changing...'),
            'class' => 'btn btn-info',
        ]
    ]
]) ?>
<?= $modalButton->form->field($model, 'per_hour_limit') ?>
<?= $modalButton->form->field($model, 'block_send')->checkbox() ?>
<?php ModalButton::end() ?>
