<?php
use hipanel\helpers\Url;
use hipanel\widgets\ModalButton;
use yii\helpers\Html;

?>

<?php if (!$model->isBlocked) {
    $modalButton = ModalButton::begin([
        'model' => $model,
        'scenario' => 'enable-block',
        'button' => ['label' => '<i class="fa fa-fw fa-lock"></i> ' . Yii::t('hipanel:hosting', 'Block domain')],
        'form' => [
            'enableAjaxValidation'   => true,
            'validationUrl'          => Url::toRoute(['validate-form', 'scenario' => 'enable-block']),
        ],
        'modal' => [
            'header' => Html::tag('h4', Yii::t('hipanel:hosting', 'Confirm hosting domain blocking')),
            'headerOptions' => ['class' => 'label-danger'],
            'footer' => [
                'label' => Yii::t('hipanel', 'Block'),
                'data-loading-text' => Yii::t('hipanel', 'Blocking...'),
                'class' => 'btn btn-danger',
            ],
        ],
    ]); ?>
    <div class="callout callout-warning">
        <h4><?= Yii::t('hipanel:hosting', 'This action will block access to the website from the world!') ?></h4>
    </div>

    <?php echo $modalButton->form->field($model, 'type')->dropDownList($blockReasons); ?>
    <?php echo $modalButton->form->field($model, 'comment'); ?>

    <?php $modalButton->end();
} else {
    $modalButton = ModalButton::begin([
        'model' => $model,
        'scenario' => 'disable-block',
        'button' => ['label' => '<i class="ion-unlocked"></i>' . Yii::t('hipanel:hosting', 'Unblock domain')],
        'form' => [
            'enableAjaxValidation'   => true,
            'validationUrl'          => Url::toRoute(['validate-form', 'scenario' => 'disable-block']),
        ],
        'modal' => [
            'header' => Html::tag('h4', Yii::t('hipanel:hosting', 'Confirm hosting domain unblocking')),
            'headerOptions' => ['class' => 'label-info'],
            'footer' => [
                'label' => Yii::t('hipanel', 'Unblock'),
                'data-loading-text' => Yii::t('hipanel', 'Unblocking...'),
                'class' => 'btn btn-info',
            ],
        ],
    ]); ?>

    <?php echo $modalButton->form->field($model, 'comment'); ?>

    <?php $modalButton->end();
}
