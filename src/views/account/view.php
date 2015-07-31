<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\AccountGridView;
use hipanel\widgets\ArraySpoiler;
use hipanel\widgets\PasswordInput;
use hipanel\widgets\Pjax;
use hipanel\widgets\RequestState;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

$this->title                   = $model->login;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<? Pjax::begin(Yii::$app->params['pjax']) ?>

    <div class="box box-danger">
        <div class="box-header">
            <?php
            $model->scenario = 'set-password';
            $form            = \yii\bootstrap\ActiveForm::begin([
                'action'  => Url::toRoute(['set-password']),
                'options' => [
                    'data'  => ['pjax' => 1],
                    'class' => 'inline',
                ]
            ]);
            print Html::activeHiddenInput($model, 'id');
            $this->registerJs("$('#{$form->id}').on('beforeSubmit', function (event) {
                            if ($(this).data('yiiActiveForm').validated) {
                                return $(this).find('[type=\"submit\"]').button('loading');
                            }
                        });");
            Modal::begin([
                'toggleButton'  => [
                    'label'    => '<i class="fa fa-lock"></i>&nbsp;&nbsp;' . Yii::t('app', 'Change password'),
                    'class'    => 'btn btn-default',
                    'disabled' => !$model->isOperable(),
                ],
                'header'        => Html::tag('h4', Yii::t('app', 'Enter a new password')),
                'headerOptions' => ['class' => 'label-info'],
                'footer'        => Html::submitButton(Yii::t('app', 'Change'), [
                    'class'             => 'btn btn-warning',
                    'data-loading-text' => Yii::t('app', 'Changing...'),
                ])
            ]);
            ?>
            <div class="callout callout-warning">
                <h4><?= Yii::t('app', 'This will immediately terminate all sessions of the user!') ?></h4>
            </div>

            <?php echo $form->field($model, 'password')->widget(PasswordInput::className())->label(false);
            echo $form->field($model, 'login')->hiddenInput()->label(false);
            Modal::end();
            $form->end();
            ?>

            <?php
            $model->scenario = 'update';
            $form            = \yii\bootstrap\ActiveForm::begin([
                'action'  => Url::toRoute(['set-allowed-ips']),
                'options' => [
                    'data'  => ['pjax' => 1],
                    'class' => 'inline',
                ],
            ]);
            print Html::activeHiddenInput($model, 'id');
            $this->registerJs("$('#{$form->id}').on('beforeSubmit', function (event) {
                            if ($(this).data('yiiActiveForm').validated) {
                                return $(this).find('[type=\"submit\"]').button('loading');
                            }
                        });");
            Modal::begin([
                'toggleButton'  => [
                    'label'    => '<i class="fa fa-globe"></i>&nbsp;&nbsp;' . Yii::t('app', 'Change SSH/FTP IPs'),
                    'class'    => 'btn btn-default',
                    'disabled' => !$model->isOperable(),
                ],
                'header'        => Html::tag('h4', Yii::t('app', 'Enter new restrictions')),
                'headerOptions' => ['class' => 'label-info'],
                'footer'        => Html::submitButton(Yii::t('app', 'Change'), [
                    'class'             => 'btn btn-warning',
                    'data-loading-text' => Yii::t('app', 'Changing...'),
                ])
            ]);
            ?>
            <div class="callout callout-warning">
                <h4><?= Yii::t('app', 'This will immediately terminate all sessions of the user!') ?></h4>
            </div>

            <?php echo $form->field($model, 'sshftp_ips');
            Modal::end();
            $form->end();
            ?>

            <?= Html::a('<i class="fa fa-close"></i>&nbsp;&nbsp;' . Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger pull-right',
                'data'  => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this account?'),
                    'method'  => 'post',
                ],
            ]) ?>
        </div>
    </div>
<div class="row" xmlns="http://www.w3.org/1999/html">
    <div class="col-md-5">
        <div class="box box-info">
            <div class="box-body">
                <div class="event-view">
                    <?= AccountGridView::detailView([
                        'model'   => $model,
                        'columns' => [
                            'seller_id',
                            'client_id',
                            'server',
                            'account',
                            [
                                'attribute' => 'state',
                                'format'    => 'raw',
                                'value'     => function ($model) {
                                    return RequestState::widget([
                                        'model'         => $model,
                                        'clientOptions' => [
                                            'afterChange' => new JsExpression("function () { $.pjax.reload('#content-pjax', {'timeout': 0});}")
                                        ]
                                    ]);
                                }
                            ],
                            [
                                'attribute' => 'password',
                                'format'    => 'raw',
                                'value'     => function () { return Yii::t('app', 'Only able to change'); }
                            ],
                            [
                                'attribute' => 'sshftp_ips',
                                'format'    => 'raw',
                                'value'     => function ($model) {
                                    return ArraySpoiler::widget([
                                        'data'         => $model->sshftp_ips,
                                        'visibleCount' => 3
                                    ]);
                                }
                            ]
                        ]
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php Pjax::end() ?>
