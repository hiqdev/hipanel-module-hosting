<?php

use hipanel\models\Ref;
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\widgets\combo\SshAccountCombo;
use hipanel\modules\server\models\Server;
use hipanel\modules\server\widgets\combo\PanelServerCombo;
use hiqdev\combo\StaticCombo;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $this \yii\web\View
 * @var $models \hipanel\modules\hosting\models\Hdomain[]
 * @var $model \hipanel\modules\hosting\models\Hdomain
 * @var $type string
 */
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
]) ?>

<div class="container-items">
    <?php foreach ($models as $i => $model) : ?>
        <div class="row">
            <div class="col-md-4">
                <div class="box box-danger">
                    <div class="box-body">
                        <div class="form-instance">
                            <?php
                            if (Yii::$app->user->can('support')) {
                                echo $form->field($model, "[$i]client")->widget(ClientCombo::class, [
                                    'formElementSelector' => '.form-instance',
                                ]);
                            }

                            echo $form->field($model, "[$i]server")->widget(PanelServerCombo::class, [
                                'formElementSelector' => '.form-instance',
                                'state' => Server::STATE_OK,
                            ]);
                            echo $form->field($model, "[$i]account")->widget(SshAccountCombo::class, [
                                'formElementSelector' => '.form-instance',
                                'inputOptions' => [
                                    'data-attribute' => 'account',
                                ],
                                'pluginOptions' => [
                                    'onChange' => new \yii\web\JsExpression(<<<'JS'
                                            function (event) {
                                                var element = $(event.target),
                                                    form = element.closest('.form-instance'),
                                                    data;

                                                if (element.val()) {
                                                    data = {
                                                        account: element.data('field').getData()[0].text,
                                                        domain: form.find('input[data-attribute="domain"]').val()
                                                    };
                                                } else {
                                                    data = {clear: true};
                                                }
                                                form.find('input[data-attribute=path]').trigger('updatePath', data);
                                                return true;
                                            }
JS
                                    ),
                                ],
                            ]);
                            echo $form->field($model, "[$i]domain")->input('text', ['data-attribute' => 'domain']);
                            $fieldOptions = ['inputOptions' => ['data-attribute' => 'path']];
                            if (!Yii::$app->user->can('support')) {
                                $fieldOptions['template'] = '{label}
                                        <div class="input-group">
                                            <span class="input-group-addon">/home/</span>
                                            {input}
                                            {hint}
                                        </div>
                                        {error}';
                            }
                            echo $form->field($model, "[$i]path", $fieldOptions);
                            echo $form->field($model, "[$i]with_www")->checkbox();
                            echo $form->field($model, "[$i]dns_on")->checkbox()
                                ->label(Yii::t('hipanel:hosting', 'DNS is enabled'))
                                ->hint(Yii::t('hipanel:hosting', 'This option will automatically create A records for this domain and its\' aliases. Changes will be uploaded to the NS servers immediately'));

                            echo $this->render('_form_ip_proxy', compact('model', 'form', 'i'));

                            echo $form->field($model, "[$i]backuping_type")->widget(StaticCombo::class, [
                                'formElementSelector' => '.form-instance',
                                'hasId' => true,
                                'data' => Ref::getList('type,backuping', 'hipanel.hosting.backuping.periodicity'),
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
    <div class="row">
        <div class="col-md-4">
            <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?>
            &nbsp;
            <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end() ?>
