<?php

/* @var $this View */
/* @var $model hipanel\modules\hosting\models\Account */
/* @var $type string */

use hipanel\base\View;
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\widgets\combo\AccountPathCombo;
use hipanel\modules\hosting\widgets\combo\SshAccountCombo;
use hipanel\modules\server\widgets\combo\ServerCombo;
use hipanel\widgets\PasswordInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>

<?php $form = ActiveForm::begin([
    'id'                     => 'dynamic-form',
    'enableClientValidation' => true,
    'validateOnBlur'         => true,
    'enableAjaxValidation'   => true,
    'validationUrl'          => Url::toRoute(['validate-form', 'scenario' => $model->isNewRecord ? reset($models)->scenario : 'update']),
]) ?>

    <div class="container-items"><!-- widgetContainer -->
        <?php foreach ($models as $i => $model) { ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="ticket-form" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
                                <?php
                                if (!$model->isNewRecord) {
                                    $model->setScenario('update');
                                    echo Html::activeHiddenInput($model, "[$i]id");
                                };
                                ?>

                                <?php
                                print $form->field($model, "[$i]client")->widget(ClientCombo::className());
                                print $form->field($model, "[$i]server")->widget(ServerCombo::className());
                                if ($model->scenario === 'create-ftponly') {
                                    print $form->field($model, "[$i]account")->widget(SshAccountCombo::className());
                                }

                                print $form->field($model, "[$i]login");
                                print $form->field($model, "[$i]password")->widget(PasswordInput::className());

                                if ($model->scenario === 'create-ftponly') {
                                    print $form->field($model, "[$i]path")->widget(AccountPathCombo::className());
                                }

                                print $form->field($model, "[$i]sshftp_ips")->hint(Yii::t('app',
                                    'Access to the account is opened by default. Please input the IPs, for which the access to the server will be granted'))
                                           ->input('text', [
                                               'data'  => [
                                                   'title'   => Yii::t('app', 'IP restrictions'),
                                                   'content' => Yii::t('app', 'Text about IP restrictions'),
                                               ],
                                               'value' => $model->getSshFtpIpsList()
                                           ]);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-default']) ?>
    &nbsp;
<?= Html::button(Yii::t('app', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>
<?php ActiveForm::end();

$this->registerJs("
    $('#account-sshftp_ips').popover({placement: 'top', trigger: 'focus'});
");