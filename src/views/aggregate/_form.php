<?php

/* @var $this yii\web\View */

/* @var $model hipanel\modules\hosting\models\Aggregate */

use hiqdev\combo\StaticCombo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

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
                <?= $form->field($model, 'rir')->widget(StaticCombo::class, [
                    'data' => $this->context->getRefs('type,ip_rir', 'hipanel.hosting.ipam'),
                    'hasId' => true,
                    'multiple' => false,
                ])->hint(Yii::t('hipanel.hosting.ipam', 'Regional Internet Registry responsible for this prefix')) ?>
                <?= $form->field($model, 'note')->textarea(['rows' => 3]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <?= Html::submitButton(Yii::t('hipanel', 'Create'), ['class' => 'btn btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
