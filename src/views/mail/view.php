<?php

use hipanel\modules\hosting\grid\DbGridView;
use hipanel\modules\hosting\grid\MailGridView;
use hipanel\widgets\Box;
use hipanel\widgets\ModalButton;
use hipanel\widgets\PasswordInput;
use yii\bootstrap\Modal;
use yii\helpers\Html;

$this->title = $model->mail;
$this->subtitle = Yii::t('app', 'Mailbox detailed information') . ' #' . $model->id;
$this->breadcrumbs->setItems([
    ['label' => Yii::t('app', 'Mailboxes'), 'url' => ['index']],
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
            <span class="profile-user-role"><?= $model->mail ?></span>
            <br>
            <span class="profile-user-name"><?= $model->client . ' / ' . $model->seller; ?></span>
        </p>

        <div class="profile-usermenu">
            <ul class="nav">
                <li><?= Html::a('<i class="fa fa-pencil"></i>' . Yii::t('app', 'Edit'), ['update', 'id' => $model->id]) ?></li>
                <li>
                    <?= ModalButton::widget([
                        'model' => $model,
                        'scenario' => 'delete',
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
                            ['name' => $model->mail]
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
                echo $box->renderTitle(Yii::t('app', 'Mailbox information'));
                $box->endHeader();
                $box->beginBody();
                echo MailGridView::detailView([
                    'boxed' => false,
                    'model' => $model,
                    'columns' => [
                        'client_id',
                        'seller_id',
                        'server_id',
                        'forwards',
                        'spam_action',
                        'state',
                        'type',
                    ],
                ]);
                $box->endBody();
                $box->end();
                ?>
            </div>
        </div>
    </div>
</div>
