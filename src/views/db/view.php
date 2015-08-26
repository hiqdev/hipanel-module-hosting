<?php

use hipanel\modules\hosting\grid\DbGridView;
use hipanel\widgets\Box;
use hipanel\widgets\ModalButton;
use hipanel\widgets\PasswordInput;
use yii\bootstrap\Modal;
use yii\helpers\Html;

$this->title = $model->name;
$this->subtitle = Yii::t('app', 'database detailed information') . ' #' . $model->id;
$this->breadcrumbs->setItems([
    ['label' => 'Databases', 'url' => ['index']],
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
                        ],
                        'modal' => [
                            'header' => Html::tag('h4', Yii::t('app', 'Enter new database password')),
                            'headerOptions' => ['class' => 'label-info'],
                            'footer' => [
                                'label' => Yii::t('app', 'Change'),
                                'data-loading-text' => Yii::t('app', 'Changing...'),
                                'class' => 'btn btn-info',
                            ]
                        ]
                    ]);
                    ?>

                    <div class="callout callout-warning">
                        <h4><?= Yii::t('app', 'This will immediately terminate all sessions of the user!') ?></h4>
                    </div>

                    <?php
                    echo $modalButton->form->field($model,
                        'password')->widget(PasswordInput::className())->label(false);
                    ModalButton::end();
                    ?>
                </li>
                <li>
                    <?= ModalButton::widget([
                        'model' => $model,
                        'scenario' => 'truncate',
                        'button' => [
                            'label' => '<i class="fa fa-file-o"></i>' . Yii::t('app', 'Truncate'),
                        ],
                        'modal' => [
                            'header' => Html::tag('h4', Yii::t('app', 'Confirm database truncating')),
                            'headerOptions' => ['class' => 'label-info'],
                            'footer' => [
                                'label' => Yii::t('app', 'Truncate database'),
                                'data-loading-text' => Yii::t('app', 'Truncating database...'),
                                'class' => 'btn btn-warning',
                            ]
                        ],
                        'body' => Yii::t('app',
                            'Are you sure that you want to truncate database {name}? All tables will be dropped, including data and structure!',
                            ['name' => $model->name]
                        )
                    ]) ?>
                </li>
                <li>
                    <?= ModalButton::widget([
                        'model' => $model,
                        'scenario' => 'truncate',
                        'button' => [
                            'label' => '<i class="fa fa-trash-o"></i>' . Yii::t('app', 'Delete'),
                        ],
                        'modal' => [
                            'header' => Html::tag('h4', Yii::t('app', 'Confirm database deleting')),
                            'headerOptions' => ['class' => 'label-info'],
                            'footer' => [
                                'label' => Yii::t('app', 'Delete database'),
                                'data-loading-text' => Yii::t('app', 'Deleting database...'),
                                'class' => 'btn btn-danger',
                            ]
                        ],
                        'body' => Yii::t('app',
                            'Are you sure, that you want to delete database {name}? All tables will be dropped, all data will be lost.',
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
                echo $box->renderTitle(Yii::t('app', 'Database information'));
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
                    ],
                ]);
                $box->endBody();
                $box::end();
                ?>
            </div>
        </div>
    </div>
</div>