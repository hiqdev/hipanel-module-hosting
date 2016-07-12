<?php

use hipanel\modules\hosting\grid\AccountGridView;
use hipanel\widgets\Box;
use hipanel\widgets\ClientSellerLink;
use hipanel\widgets\ModalButton;
use hipanel\widgets\PasswordInput;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->login;
$this->subtitle = Yii::t('hipanel/hosting', 'Account detailed information') . ' #' . $model->id;
$this->breadcrumbs->setItems([
    ['label' => Yii::t('hipanel/hosting', 'Accounts'), 'url' => ['index']],
    $this->title,
]);

?>
<div class="row">
    <div class="col-md-3">
        <?php Box::begin([
            'options' => [
                'class' => 'box-solid',
            ],
            'bodyOptions' => [
                'class' => 'no-padding'
            ]
        ]); ?>
        <div class="profile-user-img text-center">
            <i class="fa fa-user fa-5x"></i>
        </div>
        <p class="text-center">
            <span class="profile-user-name"><?= $model->login ?></span>
            <br>
            <span class="profile-user-name"><?= ClientSellerLink::widget(compact('model')) ?></span>
        </p>

        <div class="profile-usermenu">
            <ul class="nav">
                <li>
                    <?php $modalButton = ModalButton::begin([
                        'model' => $model,
                        'scenario' => 'set-password',
                        'button' => [
                            'label' => '<i class="fa fa-lock"></i>' . Yii::t('hipanel', 'Change password'),
                            'disabled' => !$model->isOperable(),
                        ],
                        'modal' => [
                            'header' => Html::tag('h4', Yii::t('hipanel/hosting', 'Enter a new password')),
                            'headerOptions' => ['class' => 'label-info'],
                            'footer' => [
                                'label' => Yii::t('hipanel', 'Change'),
                                'data-loading-text' => Yii::t('hipanel', 'Changing...'),
                                'class' => 'btn btn-warning',
                            ]
                        ]
                    ]) ?>
                        <div class="callout callout-warning">
                            <h4><?= Yii::t('hipanel/hosting', 'This will immediately terminate all sessions of the user!') ?></h4>
                        </div>

                        <?= $modalButton->form->field($model, 'password')->widget(PasswordInput::class)->label(false) ?>
                        <?= Html::activeHiddenInput($model, 'login') ?>
                    <?php ModalButton::end() ?>
                </li>
                <li>
                    <?php $modalButton = ModalButton::begin([
                        'model' => $model,
                        'scenario' => 'set-allowed-ips',
                        'button' => [
                            'label' => '<i class="fa fa-globe"></i>' . Yii::t('hipanel/hosting', 'Manage IP restrictions'),
                            'disabled' => !$model->isOperable(),
                        ],
                        'modal' => [
                            'header' => Html::tag('h4', Yii::t('hipanel/hosting', 'Enter new restrictions')),
                            'headerOptions' => ['class' => 'label-info'],
                            'footer' => [
                                'label' => Yii::t('hipanel', 'Change'),
                                'data-loading-text' => Yii::t('hipanel', 'Changing...'),
                                'class' => 'btn btn-warning',
                            ]
                        ],
                        'form' => [
                            'enableAjaxValidation' => true,
                            'enableClientValidation' => true,
                            'validationUrl' => ['single-validate-form', 'scenario' => 'set-allowed-ips']
                        ],
                    ]) ?>
                        <div class="callout callout-warning">
                            <h4><?= Yii::t('hipanel/hosting', 'This will immediately terminate all sessions of the user!') ?></h4>
                        </div>

                        <?= $modalButton->form->field($model, 'sshftp_ips') ?>
                        <?= Html::activeHiddenInput($model, 'login') ?>
                    <?php ModalButton::end() ?>
                </li>
                <?php if ($model->canSetMailSettings()) : ?>
                    <li>
                        <?php $modalButton = ModalButton::begin([
                            'model' => $model,
                            'scenario' => 'set-mail-settings',
                            'button' => [
                                'label' => '<i class="fa fa-envelope-o"></i>' . Yii::t('hipanel/hosting', 'Mail settings'),
                                'disabled' => !$model->isOperable(),
                            ],
                            'modal' => [
                                'header' => Html::tag('h4', Yii::t('hipanel/hosting', 'Enter mail settings')),
                                'headerOptions' => ['class' => 'label-info'],
                                'footer' => [
                                    'label' => Yii::t('hipanel', 'Change'),
                                    'data-loading-text' => Yii::t('hipanel', 'Changing...'),
                                    'class' => 'btn btn-info',
                                ]
                            ]
                        ]) ?>
                            <?= $modalButton->form->field($model, 'per_hour_limit') ?>
                            <?= $modalButton->form->field($model, 'block_send')->checkbox() ?>
                        <?php ModalButton::end() ?>
                    </li>
                <?php endif ?>
                <?php if (Yii::$app->user->can('support') && Yii::$app->user->id !== $model->client_id) : ?>
                    <li>
                        <?= $this->render('_block', compact(['model', 'blockReasons'])) ?>
                    </li>
                <?php endif ?>
                <li>
                    <?= ModalButton::widget([
                        'model'    => $model,
                        'scenario' => 'delete',
                        'button'   => ['label' => '<i class="fa fa-trash-o"></i>' . Yii::t('hipanel', 'Delete')],
                        'body'     => Yii::t('hipanel/hosting',
                                            'Are you sure you want to delete account {name}? You will loose all data, that relates this account!',
                                        ['name' => $model->login]),
                        'modal'    => [
                            'header'        => Html::tag('h4', Yii::t('hipanel/hosting', 'Confirm account deleting')),
                            'headerOptions' => ['class' => 'label-danger'],
                            'footer' => [
                                'label' => Yii::t('hipanel', 'Delete'),
                                'data-loading-text' => Yii::t('hipanel', 'Deleting...'),
                                'class' => 'btn btn-danger',
                            ]
                        ]
                    ]) ?>
                </li>
            </ul>
        </div>
        <?php Box::end() ?>
    </div>

    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <?php
                $box = Box::begin(['renderBody' => false]);
                $box->beginHeader();
                echo $box->renderTitle(Yii::t('hipanel/hosting', 'Account information'));
                $box->endHeader();
                $box->beginBody();
                echo AccountGridView::detailView([
                    'boxed' => false,
                    'model' => $model,
                    'columns' => [
                        'seller_id',
                        'client_id',
                        ['attribute' => 'login'],
                        'type',
                        'state',
                        'sshftp_ips',
                        'per_hour_limit'
                    ],
                ]);
                $box->endBody();
                $box->end();
                ?>
            </div>
        </div>
    </div>
</div>
