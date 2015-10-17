<?php


use hipanel\modules\hosting\widgets\ip\BackIpCombo;
use hipanel\modules\hosting\widgets\ip\FrontIpCombo;
use hipanel\modules\hosting\widgets\ip\HdomainIpCombo;
use yii\web\JsExpression;

print $form->field($model, "[$i]proxy_enabled")->checkbox([
    'class' => 'proxy_enable'
]);

$proxyEnabled = $model->proxy_enabled;

print $form->field($model, "[$i]ip", ['options' => ['class' => 'not-proxied-ip ' . ($proxyEnabled ? 'hidden' : '')]])
    ->widget(HdomainIpCombo::className(), [
        'formElementSelector' => '.form-instance',
        'pluginOptions' => [
            'activeWhen' => [
                new JsExpression("function (self) {
                    return !self.form.find('.proxy_enable').prop('checked');
                }")
            ]
        ]
    ]);

print $form->field($model, "[$i]ip", ['options' => ['class' => 'frontend_ip ' . (!$proxyEnabled ? 'hidden' : '')]])
    ->widget(FrontIpCombo::className(), [
        'formElementSelector' => '.form-instance',
        'inputOptions' => [
            'data-attribute' => 'frontend_ip',
        ],
        'pluginOptions' => [
            'activeWhen' => [
                new JsExpression("function (self) {
                    return self.form.find('.proxy_enable').prop('checked');
                }")
            ]
        ],
    ])->label('Frontend IP');

print $form->field($model, "[$i]backend_ip", ['options' => ['class' => 'backend_ip ' . (!$proxyEnabled ? 'hidden' : '')]])
    ->widget(BackIpCombo::className(), [
        'formElementSelector' => '.form-instance',
        'inputOptions' => [
            'data-attribute' => 'backend_ip',
        ],
        'pluginOptions' => [
            'activeWhen' => [
                new JsExpression("function (self) {
                    return self.form.find('.proxy_enable').prop('checked');
                }")
            ]
        ],
    ]);

$this->registerJs(<<<'JS'
    $('#dynamic-form').on('change', '.proxy_enable', function () {
        var $checkbox = $(this);
        var $scope = $(this).closest('.form-instance');
        var $proxied = $scope.find(".frontend_ip, .backend_ip");
        var $not_proxied = $scope.find(".not-proxied-ip");

        if ($checkbox.prop('checked')) {
            $proxied.removeClass('hidden');
            $not_proxied.addClass('hidden');
            $scope.find('input[data-attribute=account]').trigger('change');
        } else {
            $proxied.addClass('hidden').find('input').select2('enable', false);
            $not_proxied.removeClass('hidden');
            $scope.find('input[data-attribute=account]').trigger('change');
        }
    });
JS
);
