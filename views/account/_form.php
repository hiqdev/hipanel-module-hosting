<?php

/* @var $this View */
/* @var $model hipanel\modules\hosting\models\Account */
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


$type2action = [
    'user'    => 'create',
    'ftponly' => 'create-ftp'
];
?>
    <div class="row">
        <div class="col-md-4">
            <div class="box box-danger">
                <div class="box-body">
                    <div class="ticket-form" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
                        <?php
                        if ($model->isNewRecord) {
                            $action = Url::to(in_array($type, $model->getKnownTypes()) ? $type2action[$type] : 'create');
                        } else {
                            $action = Url::toRoute(['update', 'id' => $model->id]);
                        }

                        $form = ActiveForm::begin(['action' => $action]);
                        ?>
                        <!-- Properties -->

                        <?php
                        print $form->field($model, 'client')->widget(ClientCombo::className());
                        print $form->field($model, 'server')->widget(ServerCombo::className());

                        print $form->field($model, 'login');
                        print $form->field($model, 'password')->widget(PasswordInput::className());

                        print $form->field($model, 'sshftp_ips')
                            ->hint(Yii::t('app', 'Access to the account is opened by default. Please input the IPs, for which the access to the server will be granted'))
                            ->input('text', [
                               'data' => [
                                   'title'   => Yii::t('app', 'IP restrictions'),
                                   'content' => Yii::t('app', 'Text about IP restrictions'),
                               ]
                            ]);
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