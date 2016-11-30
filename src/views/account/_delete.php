<?php
use hipanel\widgets\ModalButton;
use yii\helpers\Html;

?>

<?= ModalButton::widget([
    'model' => $model,
    'scenario' => 'delete',
    'button' => ['label' => '<i class="fa fa-trash-o"></i>' . Yii::t('hipanel', 'Delete')],
    'body' => Yii::t('hipanel:hosting',
        'Are you sure you want to delete account {name}? You will loose all data, that relates this account!',
        ['name' => $model->login]),
    'modal' => [
        'header' => Html::tag('h4', Yii::t('hipanel:hosting', 'Confirm account deleting')),
        'headerOptions' => ['class' => 'label-danger'],
        'footer' => [
            'label' => Yii::t('hipanel', 'Delete'),
            'data-loading-text' => Yii::t('hipanel', 'Deleting...'),
            'class' => 'btn btn-danger',
        ]
    ]
]) ?>
