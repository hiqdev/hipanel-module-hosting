<?php

use hipanel\modules\hosting\grid\AccountGridView;
use hipanel\modules\hosting\menus\AccountDetailMenu;
use hipanel\widgets\Box;
use hipanel\widgets\ClientSellerLink;
use hipanel\widgets\ModalButton;
use hipanel\widgets\PasswordInput;
use hiqdev\menumanager\widgets\DetailMenu;
use yii\helpers\Html;

$this->title = $model->login;
$this->params['subtitle'] = Yii::t('hipanel:hosting', 'Account detailed information') . ' #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:hosting', 'Accounts'), 'url' => ['index']];
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
            <?= AccountDetailMenu::create(['model' => $model])->render(DetailMenu::class) ?>
            <!--ul class="nav">
                <li>
                </li>
            </ul-->
        </div>
        <?php Box::end() ?>
    </div>

    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <?php
                $box = Box::begin(['renderBody' => false]);
                $box->beginHeader();
                echo $box->renderTitle(Yii::t('hipanel:hosting', 'Account information'));
                $box->endHeader();
                $box->beginBody();
                echo AccountGridView::detailView([
                    'boxed' => false,
                    'model' => $model,
                    'columns' => [
                        'seller_id', 'client_id',
                        ['attribute' => 'login'],
                        'type', 'state', 'sshftp_ips', 'per_hour_limit'
                    ],
                ]);
                $box->endBody();
                $box->end();
                ?>
            </div>
        </div>
    </div>
</div>
