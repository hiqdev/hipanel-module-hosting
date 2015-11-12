<?php

/* @var $this View */
/* @var $model hipanel\modules\hosting\models\Mail */
/* @var $type string */

use hipanel\base\View;
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\widgets\combo\HdomainCombo;
use hipanel\modules\hosting\widgets\combo\MailCombo;
use hipanel\modules\hosting\widgets\combo\SshAccountCombo;
use hipanel\modules\server\widgets\combo\ServerCombo;
use hipanel\widgets\PasswordInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;

?>

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
                <div class="col-md-4">
                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="mail-form" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
                                <?php
                                if (!$model->isNewRecord) {
                                    $model->setScenario('update');
                                    echo Html::activeHiddenInput($model, "[$i]id");
                                }
                                ?>

                                <?php
                                if (Yii::$app->user->can('support')) {
                                    print $form->field($model, "[$i]client")->widget(ClientCombo::className());
                                }

                                print $form->field($model, "[$i]server")->widget(ServerCombo::className());

                                print $form->field($model, "[$i]account")->widget(SshAccountCombo::className());

                                print Html::label(Yii::t('app', 'E-mail'), Html::getInputId($model, "[$i]nick"));
                                ?>
                                <div class="form-inline">
                                    <?= $form->field($model, "[$i]nick")->input('text',  ['data-field' => 'nick'])->label(false) ?>
                                    <?= Html::tag('span', '@') ?>
                                    <?= $form->field($model, "[$i]hdomain_id")->widget(HdomainCombo::className(), [
                                        'activeWhen' => ['hosting/account'],
                                        'inputOptions' => [
                                            'data-field' => 'dns_hdomain_id',
                                        ],
                                        'pluginOptions' => [
                                            'select2Options' => [
                                                'width' => '250px',
                                            ],
                                            'onChange' => new JsExpression("function () {
                                                $(this).closest('.form-instance').find('input[data-field=\"sub-with-domain\"]').trigger('update');
                                            }
                                        ")
                                        ]
                                    ])->label(false) ?>
                                </div>

                                <?php
                                print $form->field($model, "[$i]password")->widget(PasswordInput::className());

                                print $form->field($model, "[$i]spam_action")->radioList([
                                    '' => Yii::t('app', 'Do nothing'),
                                    'remove' => Yii::t('app', 'Remove'),
                                    'forward' => Yii::t('app', 'Forward to'),
                                ]);
                                print $form->field($model, "[$i]spam_forward_mail", [
                                    'inputOptions' => [
                                        'disabled' => true
                                    ]
                                ])->widget(MailCombo::className(), [

                                ]);

                                print $form->field($model, "[$i]forwards")->widget(MailCombo::className());

                                print $form->field($model, "[$i]autoanswer")->textarea();

                                print $form->field($model, "[$i]du_limit")->textarea();
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