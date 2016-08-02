<?php

use hipanel\modules\hosting\grid\DbGridView;
use hipanel\widgets\Box;
use hipanel\widgets\ClientSellerLink;
use hipanel\widgets\ModalButton;
use hipanel\widgets\PasswordInput;
use yii\bootstrap\Modal;
use yii\helpers\Html;

$this->title = $model->name;
$this->subtitle = Yii::t('hipanel', 'Detailed information') . ' #' . $model->id;
$this->breadcrumbs->setItems([
    ['label' => Yii::t('hipanel', 'Databases'), 'url' => ['index']],
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
            <i class="fa fa-database fa-5x"></i>
        </div>
        <p class="text-center">
            <span class="profile-user-role"><?= $model->name ?></span>
            <br>
            <span class="profile-user-name"><?= ClientSellerLink::widget(compact('model')) ?></span>
        </p>

        <div class="profile-usermenu">
            <ul class="nav">
                <li>
                    <?php
                    $modalButton = ModalButton::begin([
                        'model' => $model,
                        'scenario' => 'set-password',
                        'button' => [
                            'label' => '<i class="fa fa-lock"></i>' . Yii::t('hipanel', 'Change password'),
                        ],
                        'modal' => [
                            'header' => Html::tag('h4', Yii::t('hipanel', 'New password')),
                            'headerOptions' => ['class' => 'label-info'],
                            'footer' => [
                                'label' => Yii::t('hipanel', 'Change'),
                                'data-loading-text' => Yii::t('hipanel', 'Changing...'),
                                'class' => 'btn btn-info',
                            ]
                        ]
                    ]);
                    ?>

                    <div class="callout callout-warning">
                        <h4><?= Yii::t('hipanel', 'This will immediately terminate all sessions of the user!') ?></h4>
                    </div>

                    <?php
                    echo $modalButton->form->field($model,
                        'password')->widget(PasswordInput::class)->label(false);
                    ModalButton::end();
                    ?>
                </li>
                <li>
                    <?= ModalButton::widget([
                        'model' => $model,
                        'scenario' => 'truncate',
                        'button' => [
                            'label' => '<i class="fa fa-file-o"></i>' . Yii::t('hipanel/hosting', 'Truncate'),
                        ],
                        'modal' => [
                            'header' => Html::tag('h4', Yii::t('hipanel/hosting', 'Confirm database truncating')),
                            'headerOptions' => ['class' => 'label-info'],
                            'footer' => [
                                'label' => Yii::t('hipanel/hosting', 'Truncate database'),
                                'data-loading-text' => Yii::t('hipanel', 'Performing...'),
                                'class' => 'btn btn-warning',
                            ]
                        ],
                        'body' => Yii::t('hipanel/hosting',
                            'Are you sure that to truncate database {name}? All tables will be dropped, all data will be lost!',
                            ['name' => $model->name]
                        )
                    ]) ?>
                </li>
                <li>
                    <?= ModalButton::widget([
                        'model' => $model,
                        'scenario' => 'delete',
                        'button' => [
                            'label' => '<i class="fa fa-trash-o"></i>' . Yii::t('hipanel', 'Delete'),
                        ],
                        'modal' => [
                            'header' => Html::tag('h4', Yii::t('hipanel/hosting', 'Confirm database deleting')),
                            'headerOptions' => ['class' => 'label-info'],
                            'footer' => [
                                'label' => Yii::t('hipanel/hosting', 'Delete database'),
                                'data-loading-text' => Yii::t('hipanel', 'Deleting...'),
                                'class' => 'btn btn-danger',
                            ]
                        ],
                        'body' => Yii::t('hipanel/hosting', 'Are you sure to delete database {name}? All tables will be dropped, all data will be lost!',
                            ['name' => $model->name]
                        )
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
                        echo $box->renderTitle(Yii::t('hipanel', 'Detailed information'));
                    $box->endHeader();
                    $box->beginBody();
                        echo DbGridView::detailView([
                            'boxed' => false,
                            'model' => $model,
                            'columns' => [
                                'seller_id',
                                'client_id',
                                ['attribute' => 'name'],
                                'service_ip',
                                'description',
                                'backups_widget',
                            ],
                        ]);
                    $box->endBody();
                $box->end();
                ?>
            </div>
        </div>
    </div>
</div>
