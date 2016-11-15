<?php

use hipanel\modules\hosting\grid\MailGridView;
use hipanel\modules\hosting\models\Mail;
use hipanel\widgets\Box;
use hipanel\widgets\ClientSellerLink;
use hipanel\widgets\ModalButton;
use hipanel\widgets\PasswordInput;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var $this yii\web\View
 * @var $model Mail
 */

$this->title = $model->mail;
$this->params['subtitle'] = Yii::t('hipanel', 'Detailed information') . ' #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:hosting', 'Mailboxes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

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
        ]) ?>
        <div class="profile-user-img text-center">
            <i class="fa fa-envelope-o fa-5x"></i>
        </div>
        <p class="text-center">
            <span class="profile-user-role"><?= $model->mail ?></span>
            <br>
            <span class="profile-user-name"><?= ClientSellerLink::widget(compact('model')) ?></span>
        </p>

        <div class="profile-usermenu">
            <ul class="nav">
                <li><?= Html::a('<i class="fa fa-pencil"></i>' . Yii::t('hipanel', 'Update'), ['update', 'id' => $model->id]) ?></li>
                <?php if ($model->canChangePassword()) { ?>
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
                                    'label' => Yii::t('hipanel', 'Change password'),
                                    'data-loading-text' => Yii::t('hipanel', 'Changing...'),
                                    'class' => 'btn btn-warning',
                                ]
                            ]
                        ]);
                        ?>

                        <?php echo $modalButton->form->field($model, 'password')->widget(PasswordInput::class)->label(false);

                        ModalButton::end();
                        ?>
                    </li>
                <?php } ?>
                <li>
                    <?= ModalButton::widget([
                        'model' => $model,
                        'scenario' => 'delete',
                        'button' => [
                            'label' => '<i class="fa fa-trash-o"></i>' . Yii::t('hipanel', 'Delete'),
                        ],
                        'modal' => [
                            'header' => Html::tag('h4', Yii::t('hipanel:hosting', 'Confirm mailbox deleting')),
                            'headerOptions' => ['class' => 'label-info'],
                            'footer' => [
                                'label' => Yii::t('hipanel:hosting', 'Delete mailbox'),
                                'data-loading-text' => Yii::t('hipanel', 'Deleting...'),
                                'class' => 'btn btn-danger',
                            ]
                        ],
                        'body' => Yii::t('hipanel:hosting',
                            'Are you sure to delete database {name}? All data will be lost.',
                            ['name' => $model->mail]
                        )
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
                echo $box->renderTitle(Yii::t('hipanel', 'Detailed information'));
                $box->endHeader();
                $box->beginBody();
                echo MailGridView::detailView([
                    'boxed' => false,
                    'model' => $model,
                    'columns' => [
                        'client_id', 'seller_id', 'server_id',
                        'type', 'domain', 'forwards', 'spam_action',
                        'state',
                    ],
                ]);
                $box->endBody();
                $box->end();
                ?>
            </div>
        </div>
    </div>
</div>
