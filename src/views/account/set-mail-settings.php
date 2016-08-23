<?php

/* @var $this View */
/* @var $model hipanel\modules\hosting\models\Account */
/* @var $type string */

use hipanel\base\View;
use hipanel\helpers\Url;
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\widgets\combo\SshAccountCombo;
use hipanel\modules\server\widgets\combo\PanelServerCombo;
use hiqdev\combo\StaticCombo;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $model->login;
$this->subtitle = Yii::t('hipanel/hosting', 'account mail config') . ' #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->login, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('hipanel/hosting', 'Mail config');

$form = ActiveForm::begin([
    'id'                     => 'dynamic-form',
    'enableClientValidation' => true,
    'validateOnBlur'         => true,
    'enableAjaxValidation'   => true,
    'validationUrl'          => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]) ?>

    <div class="container-items">
        <?php foreach ($models as $i => $model) : ?>
            <div class="row">
                <div class="col-md-9">
                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="form-instance" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
                                <?= $form->field($model, "[$i]id")->hiddenInput()->label(false) ?>

                                <div class="row">
                                    <?php if (Yii::$app->user->can('support')) { ?>
                                        <div class="col-md-4">
                                            <?= $form->field($model, "[$i]client")->widget(ClientCombo::class, ['inputOptions' => ['readonly' => true]]) ?>
                                        </div>
                                    <?php } ?>
                                    <div class="col-md-4">
                                        <?= $form->field($model, "[$i]server")->widget(PanelServerCombo::class, ['inputOptions' => ['readonly' => true]]) ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?= $form->field($model, "[$i]login")->widget(SshAccountCombo::class, ['inputOptions' => ['readonly' => true]]) ?>
                                    </div>
                                </div>
                                <?= $form->field($model, 'per_hour_limit') ?>
                                <?= $form->field($model, 'block_send')->checkbox() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>

    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-default']) ?>
        &nbsp;
    <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>

<?php ActiveForm::end();
