<?php

/* @var $this View */
/* @var $model hipanel\modules\hosting\models\Service */
/* @var $type string */

use hipanel\base\View;
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\server\widgets\combo\ServerCombo;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$form = ActiveForm::begin([
    'id'                     => 'dynamic-form',
    'enableClientValidation' => true,
    'validateOnBlur'         => true,
    'enableAjaxValidation'   => true,
    'validationUrl'          => Url::toRoute(['validate-form', 'scenario' => $model->isNewRecord ? $model->scenario : 'update']),
]) ?>

    <div class="container-items"><!-- widgetContainer -->
        <?php foreach ($models as $i => $model) { ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="form-instance" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
                                <?php
                                if (Yii::$app->user->can('support')) {
                                    print $form->field($model, "[$i]client")->widget(ClientCombo::className(), ['formElementSelector' => '.form-instance']);
                                }

                                print $form->field($model, "[$i]server")->widget(ServerCombo::className(), ['formElementSelector' => '.form-instance']);

                                print $form->field($model, "[$i]name");
                                print $form->field($model, "[$i]ips");

                                print $form->field($model, "[$i]bin");
                                print $form->field($model, "[$i]etc");

                                print $form->field($model, "[$i]soft")->dropDownList($soft_types);
                                print $form->field($model, "[$i]state")->dropDownList($states);
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
