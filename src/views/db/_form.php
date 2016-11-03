<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\widgets\combo\DbServiceCombo;
use hipanel\modules\hosting\widgets\combo\SshAccountCombo;
use hipanel\modules\server\models\Server;
use hipanel\modules\server\widgets\combo\PanelServerCombo;
use hipanel\widgets\PasswordInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model hipanel\modules\hosting\models\Db */
/* @var $type string */

$form = ActiveForm::begin([
    'id' => 'dynamic-form',
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->isNewRecord ? $model->scenario : 'update']),
]) ?>

<div class="container-items"><!-- widgetContainer -->
    <?php foreach ($models as $i => $model) { ?>
        <div class="row">
            <div class="col-md-4">
                <div class="box box-danger">
                    <div class="box-body">
                        <div class="form-instance" xmlns="http://www.w3.org/1999/html"
                             xmlns="http://www.w3.org/1999/html">
                            <?php
                            if (Yii::$app->user->can('support')) {
                                print $form->field($model, "[$i]client")->widget(ClientCombo::class, ['formElementSelector' => '.form-instance']);
                            }

                            print $form->field($model, "[$i]server")->widget(PanelServerCombo::class, [
                                'formElementSelector' => '.form-instance',
                                'state' => Server::STATE_OK
                            ]);
                            print $form->field($model, "[$i]account")->widget(SshAccountCombo::class, ['formElementSelector' => '.form-instance']);
                            print $form->field($model, "[$i]service_id")->widget(DbServiceCombo::class, ['formElementSelector' => '.form-instance']);

                            print $form->field($model, "[$i]name");
                            print $form->field($model, "[$i]password")->widget(PasswordInput::class);

                            print $form->field($model, "[$i]description");
                            ?>
                        </div>
                    </div>
                </div>

                <!-- ticket-_form -->
            </div>
        </div>
    <?php } ?>
</div>
<?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-default']) ?>
&nbsp;
<?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>
<?php ActiveForm::end(); ?>
