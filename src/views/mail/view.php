<?php

use hipanel\modules\hosting\grid\MailGridView;
use hipanel\modules\hosting\menus\MailDetailMenu;
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
            <span class="profile-user-name"><?= ClientSellerLink::widget(['model' => $model]) ?></span>
        </p>

        <div class="profile-usermenu">
            <?= MailDetailMenu::widget(['model' => $model]) ?>
        </div>
        <?php Box::end() ?>
        <div class="box box-widget">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('hipanel:hosting', 'Access credentials') ?></h3>
            </div>
            <div class="box-body">
                <dl>
                    <dt><?= Yii::t('hipanel:hosting', 'POP/IMAP') ?></dt>
                    <dd style="display: flex; justify-content: space-between">
                        mail.connecting.name
                        <?= Html::a(Yii::t('hipanel:hosting', 'Go to the site'), '//mail.connecting.name', ['target' => '_blank', 'class' => 'btn btn-default btn-xs']) ?></dd>

                    <dt><?= Yii::t('hipanel:hosting', 'SMTP') ?></dt>
                    <dd>smtp.connecting.name</dd>

                    <dt><?= Yii::t('hipanel:hosting', 'Login') ?></dt>
                    <dd><?= $model->mail ?></dd>
                </dl>
            </div>
        </div>
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
                        'state', 'du_limit',
                    ],
                ]);
                $box->endBody();
                $box->end();
                ?>
            </div>
        </div>
    </div>
</div>
