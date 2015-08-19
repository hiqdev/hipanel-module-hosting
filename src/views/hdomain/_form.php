<?php

/* @var $this View */
/* @var $model hipanel\modules\hosting\models\Hdomain */
/* @var $type string */

use hipanel\base\View;
use hipanel\models\Ref;
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\widgets\combo\SshAccountCombo;
use hipanel\modules\hosting\widgets\ip\BackIpCombo;
use hipanel\modules\hosting\widgets\ip\FrontIpCombo;
use hipanel\modules\hosting\widgets\ip\HdomainIpCombo;
use hipanel\modules\server\widgets\combo\ServerCombo;
use hiqdev\combo\StaticCombo;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;

$this->registerJs(<<<'JS'
    $('#dynamic-form').on('change', '.proxy_enable', function () {
        var $checkbox = $(this);
        var $scope = $(this).closest('.form-instance');
        var $proxied = $scope.find(".frontend_ip, .backend_ip");
        var $not_proxied = $scope.find(".not-proxied-ip");

        if ($checkbox.prop('checked')) {
            $proxied.removeClass('hidden');
            $not_proxied.addClass('hidden');
            $scope.find('input[data-field=account]').trigger('change');
        } else {
            $proxied.addClass('hidden').find('input').select2('enable', false);
            $not_proxied.removeClass('hidden');
            $scope.find('input[data-field=account]').trigger('change');
        }
    });
JS
);

$this->registerJs(<<<'JS'
/*
TODO: after ABAC - for admin
        $('.hdomain-create').find('.field-hdomain-path').on('updatePath', function (e, update) {
            var $path = $(this);
            var s_path = $path.val().split('/');
            if (s_path.length < 2 || s_path[1] != 'home') {
                s_path = ['', 'home', ''];
            }

            // 0 - /
            // 1 - home
            // 2 - user
            // 3 - domain

            if (update.account) {
                if (s_path.length > 1) {
                    s_path[2] = update.account;
                    if (!s_path[3]) s_path[3] = '';
                }
            } else if (update.domain) {
                s_path[s_path.length - 1] = update.domain.replace(/\\//g, ''); /// удаляем слеши, чтобы не собрать паровоз из пути
            } else if (update.clear) {
                s_path = [];
            }

            $path.val(s_path.join('/'));
        });
*/

        $('#dynamic-form').find('input[data-field=path]').on('updatePath', function (e, update) {
            var $group = $(this).closest('.form-group');
            var $input = $group.find('input');
            var $span = $group.find('span');

            if (update.account) $span.text('/home/' + update.account + '/');
            if (update.domain !== undefined) $input.val(update.domain);
            if (update.clear) $span.val('');
        });

        $('#dynamic-form').on('keyup keypress blur change', 'input[data-field=domain]', function () {
            var $scope = $(this).closest('.form-instance');
            $scope.find("input[data-field=path]").trigger('updatePath', {domain: $(this).val()});
        });
JS
);

$form = ActiveForm::begin([
    'id'                     => 'dynamic-form',
    'enableClientValidation' => true,
    'validateOnBlur'         => true,
    'enableAjaxValidation'   => true,
    'validationUrl'          => Url::toRoute(['validate-form', 'scenario' => $model->isNewRecord ? $model->scenario : 'update']),
]) ?>

    <div class="container-items">
        <?php foreach ($models as $i => $model) { ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="form-instance" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
                                <?php
                                print $form->field($model, "[$i]client")
                                           ->widget(ClientCombo::className(), ['formElementSelector' => '.form-instance']);
                                print $form->field($model, "[$i]server")
                                           ->widget(ServerCombo::className(), ['formElementSelector' => '.form-instance']);
                                print $form->field($model, "[$i]account")->widget(SshAccountCombo::className(), [
                                    'formElementSelector' => '.form-instance',
                                    'inputOptions'        => [
                                        'data-field' => 'account'
                                    ],
                                    'pluginOptions'       => [
                                        'onChange' => new \yii\web\JsExpression(<<<'JS'
                                            function (event) {
                                                var $form = event.element.closest('.form-instance');
                                                var data;
                                                if (event.added) {
                                                    data = {account: event.added.text};
                                                } else {
                                                    data = {clear: true};
                                                }
                                                $form.find('input[data-field=path]').trigger('updatePath', data);
                                                return true;
                                            }
JS
                                        )
                                    ],
                                ]);
                                print $form->field($model, "[$i]domain")->input('text', ['data-field' => 'domain']);
                                print $form->field($model, "[$i]path", [
                                    'inputOptions' => [
                                        'data-field' => 'path'
                                    ],
                                    'template'     => '{label}
                                        <div class="input-group">
                                            <span class="input-group-addon">/home/</span>
                                            {input}
                                            {hint}
                                            {error}
                                        </div>',
                                ]);
                                print $form->field($model, "[$i]with_www")->checkbox();

                                print $form->field($model, "[$i]proxy_enable")->checkbox([
                                    'class' => 'proxy_enable'
                                ]);

                                print $form->field($model, "[$i]ip", ['options' => ['class' => 'not-proxied-ip']])
                                           ->widget(HdomainIpCombo::className(), [
                                               'formElementSelector' => '.form-instance',
                                               'pluginOptions'       => [
                                                   'activeWhen' => [
                                                       new JsExpression("function (self) {
                                                return !self.form.find('.proxy_enable').prop('checked');
                                            }")
                                                   ]
                                               ]
                                           ]);

                                print $form->field($model, "[$i]ip", ['options' => ['class' => 'hidden frontend_ip']])
                                           ->widget(FrontIpCombo::className(), [
                                               'formElementSelector' => '.form-instance',
                                               'inputOptions'        => [
                                                   'data-field' => 'frontend_ip',
                                               ],
                                               'pluginOptions'       => [
                                                   'activeWhen' => [
                                                       new JsExpression("function (self) {
                                                            return self.form.find('.proxy_enable').prop('checked');
                                                       }")
                                                   ]
                                               ],
                                           ])->label('Frontend IP');

                                print $form->field($model, "[$i]backend_ip", ['options' => ['class' => 'hidden backend_ip']])
                                           ->widget(BackIpCombo::className(), [
                                               'formElementSelector' => '.form-instance',
                                               'inputOptions'        => [
                                                   'data-field' => 'backend_ip',
                                               ],
                                               'pluginOptions'       => [
                                                   'activeWhen' => [
                                                       new JsExpression("function (self) {
                                                            return self.form.find('.proxy_enable').prop('checked');
                                                       }")
                                                   ]
                                               ],
                                           ]);

                                print $form->field($model, "[$i]backuping_type")->widget(StaticCombo::className(), [
                                    'formElementSelector' => '.form-instance',
                                    'hasId'               => true,
                                    'data'                => Ref::getList('type,backuping'),
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-default']) ?>
    &nbsp;
<?= Html::button(Yii::t('app', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>
<?php ActiveForm::end();

//$this->registerJs("$('#hdomain-proxy_enable').trigger('change');");