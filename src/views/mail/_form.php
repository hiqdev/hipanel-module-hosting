<?php

/* @var $this View */
/* @var $model hipanel\modules\hosting\models\Mail */
/* @var $type string */

use hipanel\base\View;
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\widgets\combo\MultipleMailCombo;
use hipanel\modules\hosting\widgets\combo\SshAccountCombo;
use hipanel\modules\hosting\widgets\combo\VhostCombo;
use hipanel\modules\server\widgets\combo\PanelServerCombo;
use hipanel\widgets\PasswordInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;

?>

<?php $form = ActiveForm::begin([
    'id' => 'dynamic-form',
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute([
        'validate-form',
        'scenario' => reset($models)->isNewRecord ? reset($models)->scenario : 'update'
    ]),
]) ?>

    <div class="container-items"><!-- widgetContainer -->
        <?php foreach ($models as $i => $model) { ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="form-instance" xmlns="http://www.w3.org/1999/html"
                                 xmlns="http://www.w3.org/1999/html">
                                <?php
                                if (!$model->isNewRecord) {
                                    $model->setScenario('update');
                                    echo Html::activeHiddenInput($model, "[$i]id");
                                }
                                ?>

                                <?php
                                if (Yii::$app->user->can('support')) {
                                    print $form->field($model, "[$i]client")->widget(ClientCombo::class, [
                                        'formElementSelector' => '.form-instance',
                                        'inputOptions' => [
                                            'readonly' => !$model->isNewRecord
                                        ]
                                    ]);
                                }

                                print $form->field($model, "[$i]server")->widget(PanelServerCombo::class, [
                                    'formElementSelector' => '.form-instance',
                                    'inputOptions' => [
                                        'readonly' => !$model->isNewRecord
                                    ]
                                ]);

                                print $form->field($model, "[$i]account")->widget(SshAccountCombo::class,[
                                    'formElementSelector' => '.form-instance',
                                    'inputOptions' => [
                                        'readonly' => !$model->isNewRecord
                                    ]
                                ]);

                                print Html::label(Yii::t('hipanel', 'E-mail'), Html::getInputId($model, "[$i]nick"));
                                ?>
                                <div class="form-inline">
                                    <?= $form->field($model, "[$i]nick")->input('text', [
                                        'data-field' => 'nick',
                                        'readonly' => !$model->isNewRecord
                                    ])->label(false) ?>
                                    <?= Html::tag('span', '@') ?>
                                    <?= $form->field($model, "[$i]hdomain_id")->widget(VhostCombo::class, [
                                        'formElementSelector' => '.form-instance',
                                        'inputOptions' => [
                                            'data-field' => 'dns_hdomain_id',
                                            'readonly' => !$model->isNewRecord
                                        ],
                                        'pluginOptions' => [
                                            'select2Options' => [
                                                'width' => '250px',
                                            ]
                                        ]
                                    ])->label(false) ?>
                                </div>

                                <?php
                                print $form->field($model, "[$i]password")->widget(PasswordInput::class, [
                                    'inputOptions' => [
                                        'disabled' => $model->type === $model::TYPE_FORWARD_ONLY
                                    ]
                                ]);

                                if ($model->spam_action !== '' && $model->spam_action !== 'delete') {
                                    $model->spam_forward_mail = $model->spam_action;
                                    $model->spam_action = 'forward';
                                }

                                print $form->field($model, "[$i]spam_action")->radioList([
                                    ''        => Yii::t('hipanel:hosting', 'Do nothing'),
                                    'delete'  => Yii::t('hipanel:hosting', 'Delete'),
                                    'forward' => Yii::t('hipanel:hosting', 'Forward to'),
                                ], [
                                    'class' => 'spam-action',
                                ]);
                                print $form->field($model, "[$i]spam_forward_mail", [
                                    'options' => [
                                        'style' => $model->spam_action !== 'forward' ? 'display: none' : ''
                                    ]
                                ])->widget(MultipleMailCombo::class, [
                                    'type' => 'hosting/spam-forward',
                                    'formElementSelector' => '.form-instance',
                                    'filter' => ['nick_ne' => ['format' => '*']],
                                    'inputOptions' => [
                                        'data-attribute' => 'spam_forward_mail',
                                        'disabled' => true,
                                    ],
                                    'activeWhen' => [
                                        'server/server',
                                        'spam_action' => new JsExpression('
                                            function (combo) {
                                                var checkbox = combo.form.find(".spam-action input[type=radio]:checked");
                                                return checkbox.val() === "forward" || checkbox.length === 0;
                                            }
                                        ')
                                    ]
                                ])->label(false);

                                $model->forwards = implode(',', $model->forwards);
                                print $form->field($model, "[$i]forwards")->widget(MultipleMailCombo::class, [
                                    'formElementSelector' => '.form-instance',
                                    'filter' => ['nick_ne' => ['format' => '*']], // It does not make sense to forward
                                                                                  // mail to the wildcard address
                                    'inputOptions' => [
                                        'data-attribute' => 'forwards',
                                    ],
                                    'activeWhen' => [
                                        'server/server',
                                    ]

                                ]);

                                print $form->field($model, "[$i]autoanswer")->textarea();

                                print $form->field($model, "[$i]du_limit", [
                                    'template' => <<<HTML
                                        {label}
                                        <div class="input-group">
                                            {input}
                                            <span class="input-group-addon">MB</span>
                                        </div>
                                        {hint}\n{error}
HTML
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?>
    &nbsp;
<?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>
<?php ActiveForm::end();

$this->registerJs(<<<'JS'
        $(this).on('change', '.spam-action', function (e) {
        console.log(1);
        var $form = $(this).closest('.form-instance');

        $forwardInput = $form.find('input[data-attribute=spam_forward_mail]');

        if ($(this).find('input[type=radio]:checked').val() == 'forward') {
            $forwardInput.trigger({type: 'change', 'force': true}).parent().show();
        } else {
            $forwardInput.trigger({type: 'change', 'force': true}).parent().hide();
        }
    });
JS
);
