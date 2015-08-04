<?php

use hipanel\modules\hosting\grid\HdomainGridView;
use hipanel\widgets\Box;
use yii\bootstrap\Modal;
use yii\helpers\Html;

$this->title    = $model->domain;
$this->subtitle = Yii::t('app', 'hosting domain detailed information') . ' #' . $model->id;
$this->breadcrumbs->setItems([
    ['label' => 'Domains', 'url' => ['index']],
    $this->title,
]);
?>

<div class="row">
    <div class="col-md-3">
        <?php Box::begin(); ?>
        <div class="profile-user-img text-center">
            <img class="img-thumbnail" src="//mini.s-shot.ru/1024x768/PNG/200/Z100/?<?= $model->domain ?>"/>
        </div>
        <p class="text-center">
            <span class="profile-user-role"><?= $model->domain ?></span>
            <br>
            <span class="profile-user-name"><?= $model->client . ' / ' . $model->seller; ?></span>
        </p>

        <div class="profile-usermenu">
            <ul class="nav">
                <li>
                    <?= Html::a('<i class="fa fa-trash-o"></i>' . Yii::t('app', 'Delete'), '#', [
                        'data-toggle' => 'modal',
                        'data-target' => "#modal_{$model->id}_delete",
                    ]); ?>

                    <?php
                    echo Html::beginForm(['delete'], "POST", ['data' => ['pjax' => 1, 'pjax-push' => 0], 'class' => 'inline']);
                    echo Html::activeHiddenInput($model, 'id');
                    Modal::begin([
                        'id'            => "modal_{$model->id}_delete",
                        'toggleButton'  => false,
                        'header'        => Html::tag('h4', Yii::t('app', 'Confirm domain deleting')),
                        'headerOptions' => ['class' => 'label-danger'],
                        'footer'        => Html::button(Yii::t('app', 'Delete domain'), [
                            'class'             => 'btn btn-danger',
                            'data-loading-text' => Yii::t('app', 'Deleting domain...'),
                            'onClick'           => new \yii\web\JsExpression("
                                    $(this).closest('form').trigger('submit');
                                    $(this).button('loading');
                                ")
                        ])
                    ]);
                    echo Yii::t('app',
                        'Are you sure, that you want to delete hosting domain {name}? All files on the server will stay untouched. You can delete them manually.',
                        ['name' => $model->domain]);
                    Modal::end();
                    echo Html::endForm();
                    ?>
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
                echo $box->renderTitle(Yii::t('app', 'Domain information'));
                $box->endHeader();
                $box->beginBody();
                echo HdomainGridView::detailView([
                    'boxed'   => false,
                    'model'   => $model,
                    'columns' => [
                        'client_id',
                        'seller_id',
                        'account',
                        'server',
                        'service',
                        'ip',
                        'state',
                    ],
                ]);
                $box->endBody();
                $box::end();
                ?>
            </div>
        </div>
    </div>
</div>