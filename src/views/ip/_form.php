<?php

/* @var View */
/* @var $model hipanel\modules\hosting\models\Ip */
/* @var $tags array */

use hipanel\modules\hosting\widgets\combo\ServiceCombo;
use hipanel\modules\server\widgets\combo\ServerCombo;
use hipanel\widgets\DynamicFormWidget;
use hiqdev\combo\StaticCombo;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;

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
    'widgetItem' => '.ip-item',
    'limit' => 20,
    'min' => 1,
    'insertButton' => '.add-ip',
    'deleteButton' => '.remove-ip',
    'model' => reset($models),
    'formId' => 'dynamic-form',
    'formFields' => [
        'ip',
    ],
]); ?>
    <div class="container-items"><!-- widgetContainer -->
        <?php foreach ($models as $i => $model) : ?>
            <div class="row ip-item">
                <div class="col-md-5">
                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="form-instance" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
                                <?php
                                if ($model->isNewRecord) {
                                    $model->id = $i;
                                }
                                echo $form->field($model, "[$i]id")->hiddenInput(['data-attribute' => 'id'])->label(false);
                                echo $form->field($model, "[$i]ip")->textInput(['readonly' => !$model->isNewRecord]);

                                DynamicFormWidget::begin([
                                    'widgetContainer' => 'dynamicform_links',
                                    'widgetBody' => '.container-ips',
                                    'widgetItem' => '.item',
                                    'limit' => 20,
                                    'min' => 1,
                                    'insertButton' => '.add-link',
                                    'deleteButton' => '.remove-link',
                                    'model' => reset($model->getAddedLinks()),
                                    'formId' => 'dynamic-form',
                                    'formFields' => [
                                        'id',
                                        'device',
                                        'service_id',
                                    ],
                                ]) ?>
                                <div class="container-ips">
                                    <?php foreach ($model->getAddedLinks() as $link_id => $link) : ?>
                                        <div class="item">
                                            <?php
                                            if ($link->isNewRecord && empty($link->ip_id)) {
                                                $link->ip_id = $i;
                                            }

                                            echo Html::activeHiddenInput($link, "[$i][$link_id]id", ['value' => $link->id]);
                                            echo Html::activeHiddenInput($link, "[$i][$link_id]ip_id", ['data-attribute' => 'ip_id', 'value' => $model->id]); ?>

                                            <label><?= Yii::t('hipanel:hosting', 'Links') ?></label>
                                            <div class="row" style="margin-bottom: 5pt">
                                                <div class="col-md-5">
                                                    <?= $form->field($link, "[$i][$link_id]device")->widget(ServerCombo::class, [
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
                                                            } else if (data.soft) {
                                                                return data.text + '<br><small>' + data.soft + '</small>';
                                                            } else {
                                                                return data.text;
                                                            }
                                                        }
                                                    ");
                                                    echo $form->field($link, "[$i][$link_id]service_id")->widget(ServiceCombo::class, [
                                                        'pluginOptions' => [
                                                            'activeWhen' => [
                                                                'server/server',
                                                            ],
                                                            'select2Options' => [
                                                                'templateResult' => $formatJs,
                                                                'templateSelection' => $formatJs,
                                                                'escapeMarkup' => new JsExpression("function (markup) {
                                                                    return markup; // Allows HTML
                                                                }")
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
                                                        <button type="button" class="add-link btn btn-default"><i class="glyphicon glyphicon-plus"></i></button>
                                                        <button type="button" class="remove-link btn btn-default"><i class="glyphicon glyphicon-minus"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php DynamicFormWidget::end();
                                print $form->field($model, "[$i]tags")->widget(StaticCombo::class, [
                                    'data' => $tags,
                                    'hasId' => true,
                                    'multiple' => true,
                                ]);
                                ?>
                                <?php if (Yii::$app->user->can('admin')) : ?>
                                    <?= $form->field($model, 'note')->textarea() ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php DynamicFormWidget::end() ?>

<?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?>
    &nbsp;
<?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>

<?php ActiveForm::end();

$this->registerJs("$('.dynamicform_links').on('afterInsert', function (e, item) {
    var new_ip_id = $(item).find('[data-attribute=ip_id]');
    var ip_id = $(item).closest('.ip-item').find('[data-attribute=id]');

    new_ip_id.val(ip_id.val());
});");
