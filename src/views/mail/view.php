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
