<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\AccountGridView;
use hipanel\widgets\ArraySpoiler;
use hipanel\widgets\Box;
use hipanel\widgets\PasswordInput;
use hipanel\widgets\Pjax;
use hipanel\widgets\RequestState;
use hiqdev\assets\flagiconcss\FlagIconCssAsset;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\web\JsExpression;

$this->title    = $model->login;
$this->subtitle = Yii::t('app', 'account detailed information') . ' #' . $model->id;
$this->breadcrumbs->setItems([
    ['label' => 'Accounts', 'url' => ['index']],
    $this->title,
]);

?>


<div class="row">
    <div class="col-md-3">
        <?php Box::begin(); ?>
        <div class="profile-user-img text-center">
            <i class="fa fa-user fa-5x"></i>
        </div>
        <p class="text-center">
            <span class="profile-user-role"><?= $model->login ?></span>
            <br>
            <span class="profile-user-name"><?= $model->client . ' / ' . $model->seller; ?></span>
        </p>

        <div class="profile-usermenu">
            <ul class="nav">
                <li>
                    <?= Html::a('<i class="fa fa-lock"></i>' . Yii::t('app', 'Change password'), '#', [
                        'data-toggle' => 'modal',
                        'data-target' => '#modal_' . $model->id . '_password',
                        'disabled'    => !$model->isOperable()
                    ]); ?>

                    <?php
                    $model->scenario = 'set-password';
                    $form            = \yii\bootstrap\ActiveForm::begin([
                        'action'  => Url::toRoute(['set-password']),
                        'options' => [
                            'data'  => ['pjax' => 1],
                            'class' => 'inline',
                        ]
                    ]);
                    echo Html::activeHiddenInput($model, 'id');
                    $this->registerJs("$('#{$form->id}').on('beforeSubmit', function (event) {
                            if ($(this).data('yiiActiveForm').validated) {
                                return $(this).find('[type=\"submit\"]').button('loading');
                            }
                        });");
                    Modal::begin([
                        'id'            => 'modal_' . $model->id . '_password',
                        'toggleButton'  => false,
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
                </li>
                <li>
                    <?php
                    echo Html::a('<i class="fa fa-globe"></i>' . Yii::t('app', 'Manage IP restrictions'), '#', [
                        'data-toggle' => 'modal',
                        'data-target' => '#modal_' . $model->id . '_sshftp_ips',
                        'disabled'    => !$model->isOperable() /// TODO: check whether works
                    ]);

                    $model->scenario = 'set-allowed-ips';
                    $form            = \yii\bootstrap\ActiveForm::begin([
                        'action'  => Url::toRoute(['set-allowed-ips']),
                        'options' => [
                            'data'  => ['pjax' => 1],
                            'class' => 'inline',
                        ],
                    ]);
                    echo Html::activeHiddenInput($model, 'id');
                    $this->registerJs("$('#{$form->id}').on('beforeSubmit', function (event) {
                            if ($(this).data('yiiActiveForm').validated) {
                                return $(this).find('[type=\"submit\"]').button('loading');
                            }
                        });");
                    Modal::begin([
                        'id'            => 'modal_' . $model->id . '_sshftp_ips',
                        'toggleButton'  => false,
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
                </li>
                <li>
                    <?= Html::a('<i class="fa fa-trash-o"></i>' . Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this account?'),
                            'method'  => 'post',
                        ],
                    ]) ?>
                </li>
            </ul>
        </div>
        <?php Box::end(); ?>
    </div>

    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <?php
                $box = Box::begin(['renderBody' => false]);
                $box->beginHeader();
                    echo $box->renderTitle(Yii::t('app', 'Account information'));
                $box->endHeader();
                $box->beginBody();
                    echo AccountGridView::detailView([
                        'boxed'   => false,
                        'model'   => $model,
                        'columns' => [
                            'seller_id',
                            'client_id',
                            ['attribute' => 'login'],
                            'state',
                            'sshftp_ips'
                        ],
                    ]);
                $box->endBody();
                $box::end();
                ?>
            </div>
        </div>
    </div>
</div>