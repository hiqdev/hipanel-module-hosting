<?php

use hipanel\helpers\Url;
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\widgets\combo\SshAccountCombo;
use hipanel\modules\server\widgets\combo\PanelServerCombo;
use hiqdev\combo\StaticCombo;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model hipanel\modules\hosting\models\Vhost */
/* @var $type string */

$this->title = $model->domain;
$this->params['subtitle'] = Yii::t('hipanel/hosting', 'hosting domain advanced config') . ' #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel/hosting', 'Domains'), 'url' => ['@hdomain/index']];
$this->params['breadcrumbs'][] = ['label' => $model->domain, 'url' => ['@hdomain/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('hipanel/hosting', 'Advanced config');

?>
<?php $form = ActiveForm::begin([
    'id'                     => 'dynamic-form',
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
                                    <div class="col-md-4">
                                        <?= $form->field($model, "[$i]client")->widget(ClientCombo::class, ['formElementSelector' => '.form-instance', 'inputOptions' => ['readonly' => true]]) ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?= $form->field($model, "[$i]server")->widget(PanelServerCombo::class, ['formElementSelector' => '.form-instance', 'inputOptions' => ['readonly' => true]]) ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?= $form->field($model, "[$i]account")->widget(SshAccountCombo::class, [
                                            'formElementSelector' => '.form-instance',
                                            'inputOptions'        => [
                                                'data-field' => 'account',
                                                'readonly' => true
                                            ],
                                        ]) ?>
                                    </div>
                                </div>
                                <?= $form->field($model, "[$i]domain")->input('text', ['readonly' => true]) ?>
                                <?= $form->field($model, "[$i]docroot")->input('text', ['readonly' => true]) ?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <?= $form->field($model, "[$i]port") ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($model, "[$i]domain_prefix") ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($model, "[$i]docroot_postfix") ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($model, "[$i]cgibin_postfix"); ?>
                                    </div>
                                </div>
                                <?= $form->field($model, "[$i]enable_accesslog")->checkbox() ?>
                                <?= $form->field($model, "[$i]enable_errorslog")->checkbox() ?>
                                <?= $form->field($model, "[$i]enable_suexec")->checkbox() ?>
                                <?= $form->field($model, "[$i]enable_ssi")->checkbox() ?>
                                <?= $form->field($model, "[$i]enable_scripts")->checkbox() ?>
                                <?= $form->field($model, "[$i]apache_conf")->textarea(['rows' => 8]) ?>
                                <?= $form->field($model, "[$i]nginx_conf")->textarea(['rows' => 8]) ?>
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

<?php ActiveForm::end() ?>
