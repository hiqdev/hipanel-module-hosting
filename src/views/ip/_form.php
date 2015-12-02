<?php

/* @var $this View */
/* @var $model hipanel\modules\hosting\models\Ip */
/* @var $tags array */

use hipanel\base\View;
use hipanel\modules\hosting\widgets\combo\ServiceCombo;
use hipanel\modules\server\widgets\combo\ServerCombo;
use hipanel\widgets\DynamicFormWidget;
use hiqdev\combo\StaticCombo;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;

$form = ActiveForm::begin([
    'id'                     => 'dynamic-form',
    'enableClientValidation' => true,
    'validateOnBlur'         => true,
    'enableAjaxValidation'   => true,
    'validationUrl'          => Url::toRoute(['validate-form', 'scenario' => $model->isNewRecord ? $model->scenario : 'update']),
]);

DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper',
    'widgetBody' => '.container-items',
    'widgetItem' => '.item',
    'limit' => 20,
    'min' => 1,
    'insertButton' => '.add-item',
    'deleteButton' => '.remove-item',
    'model' => reset($models),
    'formId' => 'dynamic-form',
    'formFields' => [
        'ip',
    ],
]); ?>
    <div class="container-items"><!-- widgetContainer -->
        <?php foreach ($models as $i => $model) { ?>
            <div class="row">
                <div class="col-md-5">
                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="form-instance" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">

                                <?php
                                print $form->field($model, "[$i]ip")->textInput(['readonly' => !$model->isNewRecord]);

                                DynamicFormWidget::begin([
                                    'widgetContainer' => 'dynamicform_wrapper',
                                    'widgetBody' => '.container-ips',
                                    'widgetItem' => '.item',
                                    'limit' => 20,
                                    'min' => 1,
                                    'insertButton' => '.add-item',
                                    'deleteButton' => '.remove-item',
                                    'model' => $links[0],
                                    'formId' => 'dynamic-form',
                                    'formFields' => [
                                        'id',
                                        'ip_id',
                                        'device',
                                        'service_id',
                                    ],
                                ]) ?>
                                <div class="container-ips">
                                    <?php foreach ($links as $link) {
                                        $link_id = $link->id ?: 0;
                                        echo Html::activeHiddenInput($link, "[$link_id]id", ['value' => $link->id]);
                                        echo Html::activeHiddenInput($link, "[$link_id]ip_id", ['value' => $i]) ?>
                                        <div class="item">
                                            <div class="row" style="margin-bottom: 5pt">
                                                <div class="col-md-5">
                                                    <?= $form->field($link, "[$link_id]device")->widget(ServerCombo::className(), [
                                                        // TODO: Change to DeviceCombo when will be implemented
                                                        'pluginOptions' => [],
                                                        'formElementSelector' => '.item',
                                                        'inputOptions' => [
                                                            'data-combo-field' => 'device'
                                                        ]
                                                    ])->label(false) ?>
                                                </div>
                                                <div class="col-md-5">
                                                    <?php
                                                    $formatJs = new JsExpression("
                                                        function (data) {
                                                            if (data.text === data.soft) {
                                                                return data.text;
                                                            } else if (data.text == '') {
                                                                return data.soft;
                                                            } else {
                                                                return data.text + '<br><small>' + data.soft + '</small>';
                                                            }
                                                        }
                                                    ");
                                                    echo $form->field($link, "[$link_id]service_id")->widget(ServiceCombo::className(), [
                                                        'pluginOptions' => [
                                                            'activeWhen' => [
                                                                'server/server',
                                                            ],
                                                            'select2Options' => [
                                                                'formatResult' => $formatJs,
                                                                'formatSelection' => $formatJs,
                                                            ],
                                                        ],
                                                        'formElementSelector' => '.item',
                                                        'inputOptions' => [
                                                            'data-combo-field' => 'service_id'
                                                        ]
                                                    ])->label(false) ?>
                                                </div>
                                                <div class="col-md-2 text-right">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="add-item btn btn-default"><i class="glyphicon glyphicon-plus"></i></button>
                                                        <button type="button" class="remove-item btn btn-default"><i class="glyphicon glyphicon-minus"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php DynamicFormWidget::end();

                                print $form->field($model, "[$i]tags")->widget(StaticCombo::className(), [
                                    'data' => $tags,
                                    'hasId' => true,
                                    'pluginOptions' => [
                                        'select2Options' => [
                                            'multiple' => true
                                        ]
                                    ]
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php DynamicFormWidget::end() ?>

<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    &nbsp;
<?= Html::button(Yii::t('app', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>

<?php ActiveForm::end();
