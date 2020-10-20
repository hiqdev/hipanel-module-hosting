<?php

use hiqdev\combo\StaticCombo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model hipanel\modules\hosting\models\Prefix */

$form = ActiveForm::begin([
    'id' => 'prefix-form',
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]) ?>

<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="box box-widget">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('hipanel.hosting.ipam', 'Prefix') ?></h3>
            </div>
            <div class="box-body">
                <?= Html::activeHiddenInput($model, 'id') ?>
                <?= $form->field($model, 'ip')->hint(Yii::t('hipanel.hosting.ipam', 'IPv4 or IPv6 network with mask')) ?>
                <?= $form->field($model, 'type')
                    ->dropDownList($this->context->getRefs('type,ip_prefix', 'hipanel.hosting.ipam'))
                    ->hint(Yii::t('hipanel.hosting.ipam', 'Operational status of this prefix')) ?>
                <?= $form->field($model, 'vrf')
                    ->dropDownList($this->context->getRefs('type,ip_vrf', 'hipanel.hosting.ipam'))
                    ->hint(Yii::t('hipanel.hosting.ipam', 'Virtual Routing and Forwarding')) ?>
                <?= $form->field($model, 'role')
                    ->dropDownList($this->context->getRefs('type,ip_prefix_role', 'hipanel.hosting.ipam'), ['prompt' => '---'])
                    ->hint(Yii::t('hipanel.hosting.ipam', 'The primary function of this prefix')) ?>
                <?= $form->field($model, 'site')->dropDownList($this->context->getRefs('type,location'), ['prompt' => '---']) ?>
                <?= $form->field($model, "tags")->widget(StaticCombo::class, [
                    'data' => $model->getTagOptions(),
                    'hasId' => true,
                    'multiple' => true,
                ]) ?>
                <?= $form->field($model, 'note')->textarea(['rows' => 2]) ?>
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
