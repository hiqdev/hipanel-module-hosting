<?php

/* @var $this View */
/* @var $model hipanel\modules\hosting\models\Hdomain */
/* @var $type string */

use hipanel\components\View;
use hipanel\models\Ref;
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\widgets\combo\SshAccountCombo;
use hipanel\modules\server\widgets\combo\PanelServerCombo;
use hiqdev\combo\StaticCombo;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

if (Yii::$app->user->can('support')) {
    $this->registerJs(<<<'JS'
            $('#dynamic-form').find('input[data-attribute=path]').on('updatePath', function (e, update) {
                var $group = $(this).closest('.form-group');
                var $input = $group.find('input');

                var s_path = $input.val().split('/');
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
                }

                if (update.domain) {
                    s_path[s_path.length - 1] = update.domain.replace(/\//g, ''); /// удаляем слеши, чтобы не собрать паровоз из пути
                }

                if (update.clear) {
                    s_path = [];
                }

                $input.val(s_path.join('/'));
            });
JS
    );
} else {
    $this->registerJs(<<<'JS'
            $('#dynamic-form').find('input[data-attribute=path]').on('updatePath', function (e, update) {
                var $group = $(this).closest('.form-group');
                var $input = $group.find('input');
                var $span = $group.find('span');

                if (update.account) $span.text('/home/' + update.account + '/');
                if (update.domain !== undefined) $input.val(update.domain);
                if (update.clear) $span.val('');
            });
JS
    );
}

$this->registerJs(<<<'JS'
        $('#dynamic-form').on('keyup keypress blur change', 'input[data-attribute=domain]', function () {
            var $scope = $(this).closest('.form-instance');
            $scope.find("input[data-attribute=path]").trigger('updatePath', {domain: $(this).val()});
        });
JS
);

$form = ActiveForm::begin([
    'id' => 'dynamic-form',
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->isNewRecord ? $model->scenario : 'update']),
]); ?>

<div class="container-items">
    <?php foreach ($models as $i => $model) { ?>
        <div class="row">
            <div class="col-md-4">
                <div class="box box-danger">
                    <div class="box-body">
                        <div class="form-instance" xmlns="http://www.w3.org/1999/html"
                             xmlns="http://www.w3.org/1999/html">
                            <?php
                            if (Yii::$app->user->can('support')) {
                                print $form->field($model, "[$i]client")
                                    ->widget(ClientCombo::className(), ['formElementSelector' => '.form-instance']);
                            }

                            print $form->field($model, "[$i]server")
                                ->widget(PanelServerCombo::className(), ['formElementSelector' => '.form-instance']);
                            print $form->field($model, "[$i]account")->widget(SshAccountCombo::className(), [
                                'formElementSelector' => '.form-instance',
                                'inputOptions' => [
                                    'data-attribute' => 'account',
                                ],
                                'pluginOptions' => [
                                    'onChange' => new \yii\web\JsExpression(<<<'JS'
                                            function (event) {
                                                var $form = event.element.closest('.form-instance');
                                                var data;
                                                if (event.added) {
                                                    data = {account: event.added.text, domain: $form.find('input[data-attribute="domain"]').val()};
                                                } else {
                                                    data = {clear: true};
                                                }
                                                $form.find('input[data-attribute=path]').trigger('updatePath', data);
                                                return true;
                                            }
JS
                                    ),
                                ],
                            ]);
                            print $form->field($model, "[$i]domain")->input('text', ['data-attribute' => 'domain']);
                            $fieldOptions = ['inputOptions' => ['data-attribute' => 'path']];
                            if (!Yii::$app->user->can('support')) {
                                $fieldOptions['template'] = '{label}
                                        <div class="input-group">
                                            <span class="input-group-addon">/home/</span>
                                            {input}
                                            {hint}
                                            {error}
                                        </div>';
                            }
                            print $form->field($model, "[$i]path", $fieldOptions);
                            print $form->field($model, "[$i]with_www")->checkbox();
                            print $form->field($model, "[$i]dns_on")->checkbox()
                                ->label(Yii::t('hipanel/hosting', 'DNS is enabled'))
                                ->hint(Yii::t('hipanel/hosting', 'This option will automatically create A records for this domain and its\' aliases. Changes will be uploaded to the NS servers immediately'));


                            print $this->render('_form_ip_proxy', compact('model', 'form', 'i'));

                            print $form->field($model, "[$i]backuping_type")->widget(StaticCombo::className(), [
                                'formElementSelector' => '.form-instance',
                                'hasId' => true,
                                'data' => Ref::getList('type,backuping', 'hipanel/hosting'),
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
&nbsp;
<?= Html::button(Yii::t('app', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>
<?php ActiveForm::end(); ?>
