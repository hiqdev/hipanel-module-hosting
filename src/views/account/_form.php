<?php

/** @var View */
/** @var hipanel\modules\hosting\models\Account $model */
/** @var string $type */
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\widgets\combo\AccountPathCombo;
use hipanel\modules\hosting\widgets\combo\SshAccountCombo;
use hipanel\modules\server\models\Server;
use hipanel\modules\server\widgets\combo\PanelServerCombo;
use hipanel\widgets\PasswordInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

?>

<?php $form = ActiveForm::begin([
    'id' => 'dynamic-form',
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute([
        'validate-form',
        'scenario' => $model->isNewRecord ? reset($models)->scenario : 'update',
    ]),
]) ?>

    <div class="container-items">
        <?php foreach ($models as $i => $model) : ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="ticket-form">
                                <?php if (!$model->isNewRecord) : ?>
                                    <?php $model->setScenario('update') ?>
                                    <?= Html::activeHiddenInput($model, "[$i]id") ?>
                                <?php endif ?>

                                <?php if (Yii::$app->user->can('support')) : ?>
                                    <?= $form->field($model, "[$i]client")->widget(ClientCombo::class) ?>
                                <?php endif ?>

                                <?= $form->field($model, "[$i]server")->widget(PanelServerCombo::class, [
                                    'state' => Server::STATE_OK,
                                ]) ?>
                                <?php if ($model->scenario === 'create-ftponly') : ?>
                                    <?= $form->field($model, "[$i]account")->widget(SshAccountCombo::class) ?>
                                <?php endif ?>

                                <?= $form->field($model, "[$i]login") ?>
                                <?= $form->field($model, "[$i]password")->widget(PasswordInput::class) ?>

                                <?php if ($model->scenario === 'create-ftponly') : ?>
                                    <?= $form->field($model, "[$i]path")->widget(AccountPathCombo::class) ?>
                                <?php endif ?>

                                <?= $form->field($model, "[$i]sshftp_ips")
                                    ->hint(Yii::t('hipanel:hosting', 'Access to the account is opened by default. Please input the IPs, for which the access to the server will be granted'))
                                    ->input('text', [
                                            'data' => [
                                                'title' => Yii::t('hipanel:hosting', 'IP restrictions'),
                                                'content' => Yii::t('hipanel:hosting', 'Text about IP restrictions'), /// TODO
                                            ],
                                            'value' => $model->getSshFtpIpsList(),
                                        ]
                                    )
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
        <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?>&nbsp;
        <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>
    </div>
<?php ActiveForm::end(); ?>
<?php $this->registerJs("$('#account-sshftp_ips').popover({placement: 'top', trigger: 'focus'});"); ?>
