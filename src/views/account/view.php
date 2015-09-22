<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\AccountGridView;
use hipanel\widgets\ModalButton;
use hipanel\widgets\Box;
use hipanel\widgets\PasswordInput;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->login;
$this->subtitle = Yii::t('app', 'Account detailed information') . ' #' . $model->id;
$this->breadcrumbs->setItems([
    ['label' => Yii::t('app', 'Accounts'), 'url' => ['index']],
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
            <span class="profile-user-role"><?= $model->login ?></span>
            <br>
            <span class="profile-user-name"><?= $model->client . ' / ' . $model->seller; ?></span>
        </p>

        <div class="profile-usermenu">
            <ul class="nav">
                <li>
                    <?php
                    $modalButton = ModalButton::begin([
                        'model' => $model,
                        'scenario' => 'set-password',
                        'button' => [
                            'label' => '<i class="fa fa-lock"></i>' . Yii::t('app', 'Change password'),
                            'disabled' => !$model->isOperable(),
                        ],
                        'modal' => [
                            'header' => Html::tag('h4', Yii::t('app', 'Enter a new password')),
                            'headerOptions' => ['class' => 'label-info'],
                            'footer' => [
                                'label' => Yii::t('app', 'Change'),
                                'data-loading-text' => Yii::t('app', 'Changing...'),
                                'class' => 'btn btn-warning',
                            ]
                        ]
                    ]);
                    ?>

                    <div class="callout callout-warning">
                        <h4><?= Yii::t('app', 'This will immediately terminate all sessions of the user!') ?></h4>
                    </div>

                    <?php echo $modalButton->form->field($model,
                        'password')->widget(PasswordInput::className())->label(false);
                    echo Html::activeHiddenInput($model, 'login');

                    ModalButton::end();
                    ?>
                </li>
                <li>
                    <?php
                    $modalButton = ModalButton::begin([
                        'model' => $model,
                        'scenario' => 'set-allowed-ips',
                        'button' => [
                            'label' => '<i class="fa fa-globe"></i>' . Yii::t('app', 'Manage IP restrictions'),
                            'disabled' => !$model->isOperable(),
                        ],
                        'modal' => [
                            'header' => Html::tag('h4', Yii::t('app', 'Enter new restrictions')),
                            'headerOptions' => ['class' => 'label-info'],
                            'footer' => [
                                'label' => Yii::t('app', 'Change'),
                                'data-loading-text' => Yii::t('app', 'Changing...'),
                                'class' => 'btn btn-warning',
                            ]
                        ]
                    ]);
                    ?>

                    <div class="callout callout-warning">
                        <h4><?= Yii::t('app', 'This will immediately terminate all sessions of the user!') ?></h4>
                    </div>

                    <?php echo $modalButton->form->field($model, 'sshftp_ips');

                    echo Html::activeHiddenInput($model, 'login');

                    ModalButton::end();
                    ?>
                </li>
                <?php if ($model->canSetMailSettings()) { ?>
                    <li>
                        <?php
                        $modalButton = ModalButton::begin([
                            'model' => $model,
                            'scenario' => 'set-mail-settings',
                            'button' => [
                                'label' => '<i class="fa fa-envelope-o"></i>' . Yii::t('app', 'Mail settings'),
                                'disabled' => !$model->isOperable(),
                            ],
                            'modal' => [
                                'header' => Html::tag('h4', Yii::t('app', 'Enter mail settings')),
                                'headerOptions' => ['class' => 'label-info'],
                                'footer' => [
                                    'label' => Yii::t('app', 'Change'),
                                    'data-loading-text' => Yii::t('app', 'Changing...'),
                                    'class' => 'btn btn-info',
                                ]
                            ]
                        ]);

                        echo $modalButton->form->field($model, 'per_hour_limit');
                        echo $modalButton->form->field($model, 'block_send')->checkbox();

                        ModalButton::end();
                        ?>
                    </li>
                <?php } ?>
                <?php if (Yii::$app->user->can('support')) { ?>
                    <li>
                        <?= $this->render('_block', compact(['model', 'blockReasons'])); ?>
                    </li>
                <?php } ?>
                <li>
                    <?= ModalButton::widget([
                        'model' => $model,
                        'scenario' => 'delete',
                        'button'   => ['label' => '<i class="fa fa-trash-o"></i>' . Yii::t('app', 'Delete')],
                        'body'     => Yii::t('app',
                                            'Are you sure you want to delete account {name}? You will loose all data, that relates this account!',
                                        ['name' => $model->login]),
                        'modal'    => [
                            'header'        => Html::tag('h4', Yii::t('app', 'Confirm account deleting')),
                            'headerOptions' => ['class' => 'label-danger'],
                            'footer' => [
                                'label' => Yii::t('app', 'Delete'),
                                'data-loading-text' => Yii::t('app', 'Deleting...'),
                                'class' => 'btn btn-danger',
                            ]
                        ]
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
