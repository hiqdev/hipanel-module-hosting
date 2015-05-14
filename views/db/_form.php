<?php

/* @var $this View */
/* @var $model hipanel\modules\hosting\models\Db */
/* @var $type string */

use hipanel\base\View;
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\widgets\combo\AccountCombo;
use hipanel\modules\hosting\widgets\combo\DbServiceCombo;
use hipanel\modules\server\widgets\combo\ServerCombo;
use hipanel\widgets\PasswordInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>
    <div class="row">
        <div class="col-md-4">
            <div class="box box-danger">
                <div class="box-body">
                    <div class="ticket-form" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
                        <?php $form = ActiveForm::begin([
                            'action' => $model->isNewRecord ? Url::to('create') : Url::toRoute([
                                'update',
                                'id' => $model->id
                            ]),
                        ]);
                        ?>
                        <!-- Properties -->

                        <?php
                        print $form->field($model, 'client')->widget(ClientCombo::className());
                        print $form->field($model, 'server')->widget(ServerCombo::className());
                        print $form->field($model, 'account')->widget(AccountCombo::className());
                        print $form->field($model, 'service_id')->widget(DbServiceCombo::className());

                        print $form->field($model, 'name');
                        print $form->field($model, 'password')->widget(PasswordInput::className());

                        print $form->field($model, 'description');
                        ?>

                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-primary']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>

            <!-- ticket-_form -->
        </div>
    </div>

<?php

$this->registerJs("
    $('#account-sshftp_ips').popover({placement: 'top', trigger: 'focus'});
");