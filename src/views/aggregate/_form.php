<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model hipanel\modules\hosting\models\Aggregate */


$form = ActiveForm::begin([
    'id' => 'aggregate-form',
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]) ?>

<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="box box-widget">
            <div class="box-body">
                <?= Html::activeHiddenInput($model, 'id') ?>
                <?= $form->field($model, 'ip')->hint(Yii::t('hipanel.hosting.ipam', 'IPv4 or IPv6 network')) ?>
                <?= $form->field($model, 'rir')
                    ->dropDownList($this->context->getRefs('type,ip_rir', 'hipanel.hosting.ipam'), ['prompt' => '---'])
                    ->hint(Yii::t('hipanel.hosting.ipam', 'Regional Internet Registry responsible for this prefix')) ?>
                <?= $form->field($model, 'note')->textarea(['rows' => 3]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <?= Html::submitButton(Yii::t('hipanel', $model->isNewRecord ? 'Create' : 'Save'), ['class' => 'btn btn-success']) ?>
        &nbsp;
        <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
