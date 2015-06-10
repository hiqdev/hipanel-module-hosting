<?php

/* @var $this View */
/* @var $model hipanel\modules\hosting\models\Db */
/* @var $type string */

use hipanel\base\View;
use hipanel\models\Ref;
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\widgets\combo\AccountCombo;
use hipanel\modules\hosting\widgets\combo\DbServiceCombo;
use hipanel\modules\hosting\widgets\ip\BackIpCombo;
use hipanel\modules\hosting\widgets\ip\FrontIpCombo;
use hipanel\modules\hosting\widgets\ip\HdomainIpCombo;
use hipanel\modules\server\widgets\combo\ServerCombo;
use hipanel\widgets\PasswordInput;
use hiqdev\combo\StaticCombo;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->registerJs(<<<'JS'
    $('.hdomain-create').on('change', '#hdomain-proxy_enable', function () {
        var $checkbox = $(this);
        var $scope = $(this).closest('form');
        var $proxied = $scope.find('.field-hdomain-frontend_ip, .field-hdomain-backend_ip');
        var $not_proxied = $scope.find('.field-hdomain-not-proxied_ip');

        if ($checkbox.prop('checked')) {
            $proxied.removeClass('hidden');

            if ($scope.find('#hdomain-account').select2('data')) {
                $proxied.find('input').select2('enable', true);
            } else {
                $proxied.find('input').select2('enable', false);
            }

            $not_proxied.addClass('hidden').find('input').prop({'required': false}).select2('enable', false);
        } else {
            $proxied.addClass('hidden').find('input').select2('enable', false);
            $not_proxied.removeClass('hidden');

            if ($scope.find('#hdomain-account').select2('data')) {
                $not_proxied.find('input').select2('enable', true);
            } else {
                $not_proxied.find('input').select2('enable', false);
            }
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

        $('.hdomain-create').find('.field-hdomain-path').on('updatePath', function (e, update) {
            var $group = $(this);
            var $input = $group.find('input');
            var $span = $group.find('span');

            if (update.account) $span.text('/home/' + update.account + '/');
            if (update.domain !== undefined) $input.val(update.domain);
            if (update.clear) $span.val('');
        });

        $('.hdomain-create').on('keyup keypress blur change', '.field-hdomain-domain input', function () {
            var $scope = $(this).closest('form');
            $scope.find('.field-hdomain-path').trigger('updatePath', {domain: $(this).val()});
        });
JS
);
?>
    <div class="row">
        <div class="col-md-4">
            <div class="box box-danger">
                <div class="box-body">
                    <div class="ticket-form" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
                        <?php $form = ActiveForm::begin([
                            'action'  => $model->isNewRecord ? Url::to('create') : Url::toRoute([
                                'update',
                                'id' => $model->id
                            ]),
                            'options' => ['class' => 'hdomain-create']
                        ]);
                        ?>
                        <!-- Properties -->

                        <?php
                        print $form->field($model, 'client')->widget(ClientCombo::className());
                        print $form->field($model, 'server')->widget(ServerCombo::className());
                        print $form->field($model, 'account')->widget(AccountCombo::className(), [
                            'pluginOptions' => [
                                'onChange' => new \yii\web\JsExpression(<<<'JS'
    function (event) {
        var $form = event.element.closest('form');
        var data;
        if (event.added) {
            data = {account: event.added.text};
        } else {
            data = {clear: true};
        }
        $form.find('.field-hdomain-path').trigger('updatePath', data);
        return true;
    }
JS
                                )
                            ]
                        ]);
                        print $form->field($model, 'domain');
                        print $form->field($model, 'path', [
                            'template' => '
                                {label}
                                <div class="input-group">
                                    <span class="input-group-addon">/home/</span>
                                    {input}
                                    {hint}
                                    {error}
                                </div>
                            '
                        ]);
                        print $form->field($model, 'with_www')->checkbox();
                        print $form->field($model, 'proxy_enable')->checkbox();
                        print $form->field($model, 'ip', ['options' => ['class' => 'field-hdomain-not-proxied_ip']])
                                   ->widget(HdomainIpCombo::className());
                        print $form->field($model, 'ip', ['options' => ['class' => 'field-hdomain-frontend_ip hidden']])
                                   ->widget(FrontIpCombo::className(), ['inputOptions' => ['id' => 'hdomain-frontend_ip']])
                                   ->label('Frontend IP');
                        print $form->field($model, 'backend_ip', ['options' => ['class' => 'field-hdomain-frontend_ip hidden']])
                                   ->widget(BackIpCombo::className());
                        print $form->field($model, 'backuping_type')->widget(StaticCombo::className(), [
                            'hasId' => true,
                            'data'  => Ref::getList('type,backuping')
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