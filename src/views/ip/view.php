<?php

use hipanel\modules\hosting\grid\IpGridView;
use hipanel\modules\hosting\menus\IpDetailMenu;
use hipanel\modules\hosting\models\Ip;
use hipanel\widgets\Box;
use yii\web\View;

/**
 * @var View $this
 * @var Ip $model
 */

$this->title = $model->ip;
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:hosting', 'IP addresses'), 'url' => ['index']];
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
        ]); ?>
        <div class="profile-user-img text-center">
            <i class="fa fa-globe fa-5x"></i>
        </div>
        <p class="text-center">
            <span class="profile-user-role"><?= $model->ip ?></span>
        </p>

        <div class="profile-usermenu">
            <?= IpDetailMenu::widget(['model' => $model]) ?>
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
                echo IpGridView::detailView([
                    'boxed' => false,
                    'model' => $model,
                    'columns' => [
                        'ip', 'note', 'tags', 'counters',
                        'links', 'ptr',
                    ],
                ]);
                $box->endBody();
                $box->end();
                ?>
            </div>
        </div>
    </div>
</div>
