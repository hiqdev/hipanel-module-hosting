<?php
/* @var $this yii\web\View */
use hipanel\helpers\Url;
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\widgets\combo\SshAccountCombo;
use hipanel\modules\server\widgets\combo\PanelServerCombo;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/* @var $type string */

$this->title = $model->domain;
$this->subtitle = Yii::t('hipanel/hosting', 'Hosting domain proxy settings') . ' #' . $model->id;
$this->breadcrumbs->setItems([
    ['label' => Yii::t('hipanel/hosting', 'Domains'), 'url' => ['@hdomain/index']],
    ['label' => $this->title, 'url' => ['@hdomain/view', 'id' => $model->id]],
    Yii::t('hipanel/hosting', 'Hosting domain proxy settings')
]);
?>

<div class="db-create">
    <?php
    $form = ActiveForm::begin([
        'id' => 'dynamic-form',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
    ]); ?>
    <div class="container-items">
        <?php foreach ($models as $i => $model) { ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="form-instance" xmlns="http://www.w3.org/1999/html"
                                 xmlns="http://www.w3.org/1999/html">
                                <?php echo $form->field($model, "[$i]id")->hiddenInput()->label(false) ?>

                                <?php
                                if (Yii::$app->user->can('support')) {
                                    print $form->field($model, "[$i]client")->widget(ClientCombo::class, [
                                        'formElementSelector' => '.form-instance',
                                        'inputOptions' => ['readonly' => true]
                                    ]);
                                }
                                print $form->field($model, "[$i]server")->widget(PanelServerCombo::class, [
                                    'formElementSelector' => '.form-instance',
                                    'inputOptions' => ['readonly' => true]
                                ]);
                                print $form->field($model, "[$i]account")->widget(SshAccountCombo::class, [
                                    'formElementSelector' => '.form-instance',
                                    'inputOptions' => ['data-attribute' => 'account', 'readonly' => true]
                                ]);
                                print $form->field($model, "[$i]domain")->input('text', ['readonly' => true]);
                                ?>
                                <?php echo $this->render('/hdomain/_form_ip_proxy', compact('model', 'form', 'i')) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-default']) ?>
    &nbsp;
    <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>
    <?php $form->end() ?>
</div>
