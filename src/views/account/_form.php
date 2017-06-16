<?php

/* @var View */
/* @var $model hipanel\modules\hosting\models\Account */
/* @var $type string */

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\widgets\combo\AccountPathCombo;
use hipanel\modules\hosting\widgets\combo\SshAccountCombo;
use hipanel\modules\server\models\Server;
use hipanel\modules\server\widgets\combo\PanelServerCombo;
use hipanel\widgets\PasswordInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\web\View;

?>

<div class="account-create">

    <?php $form = ActiveForm::begin([
        'id' => 'dynamic-form',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::toRoute([
            'validate-form',
            'scenario' => $model->isNewRecord ? reset($models)->scenario : 'update'
        ]),
    ]) ?>

        <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($models as $i => $model) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-danger">
                            <div class="box-body">
                                <div class="ticket-form" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
                                    <?php
                                    if (!$model->isNewRecord) {
                                        $model->setScenario('update');
                                        echo Html::activeHiddenInput($model, "[$i]id");
                                    }
                                    ?>

                                    <?php
                                    if (Yii::$app->user->can('support')) {
                                        print $form->field($model, "[$i]client")->widget(ClientCombo::class);
                                    }

                                    print $form->field($model, "[$i]server")->widget(PanelServerCombo::class, [
                                        'state' => Server::STATE_OK
                                    ]);
                                    if ($model->scenario === 'create-ftponly') {
                                        print $form->field($model, "[$i]account")->widget(SshAccountCombo::class);
                                    }

                                    print $form->field($model, "[$i]login")->textInput(['autocomplete' => 'new-login']);
                                    print $form->field($model, "[$i]password")->textInput(['autocomplete' => 'new-password'])->widget(PasswordInput::class, [
                                            'id' => "{$i}-password-input",
                                    ]);

                                    if ($model->scenario === 'create-ftponly') {
                                        print $form->field($model, "[$i]path")->widget(AccountPathCombo::class);
                                    }

                                    print $form->field($model, "[$i]sshftp_ips")
                                        ->hint(Yii::t('hipanel:hosting', 'Access to the account is opened by default. Please input the IPs, for which the access to the server will be granted'))
                                        ->input('text', [
                                                'data' => [
                                                    'title' => Yii::t('hipanel:hosting', 'IP restrictions'),
                                                    'content' => Yii::t('hipanel:hosting', 'Text about IP restrictions'), /// TODO
                                                ],
                                                'value' => $model->getSshFtpIpsList()
                                            ]
                                        );
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-widget">
                        <div class="box-body">
                            <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
    <?php $this->registerJs("$('#account-sshftp_ips').popover({placement: 'top', trigger: 'focus'});"); ?>
</div>
