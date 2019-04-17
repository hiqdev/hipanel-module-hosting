<?php

use hipanel\modules\hosting\grid\DbGridView;
use hipanel\modules\hosting\menus\DbDetailMenu;
use hipanel\widgets\Box;
use hipanel\widgets\ClientSellerLink;

$this->title = $model->name;
$this->params['subtitle'] = Yii::t('hipanel', 'Detailed information') . ' #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel', 'Databases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-md-3">
        <?php Box::begin([
            'options' => [
                'class' => 'box-solid',
            ],
            'bodyOptions' => [
                'class' => 'no-padding',
            ],
        ]) ?>
        <div class="profile-user-img text-center">
            <i class="fa fa-database fa-5x"></i>
        </div>
        <p class="text-center">
            <span class="profile-user-role"><?= $model->name ?></span>
            <br>
            <span class="profile-user-name"><?= ClientSellerLink::widget(['model' => $model]) ?></span>
        </p>

        <div class="profile-usermenu">
            <?= DbDetailMenu::widget(['model' => $model]) ?>
        </div>
        <?php Box::end() ?>
    </div>

    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <?php
                $box = Box::begin(['renderBody' => false, 'bodyOptions' => ['class' => 'no-padding']]);
                    $box->beginHeader();
                        echo $box->renderTitle(Yii::t('hipanel', 'Detailed information'));
                    $box->endHeader();
                    $box->beginBody();
                        echo DbGridView::detailView([
                            'boxed' => false,
                            'model' => $model,
                            'columns' => [
                                ['attribute' => 'name'], 'description',
                                'info_server',
                                'access',
                                'seller_id', 'client_id',
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
