<?php

use hipanel\modules\hosting\grid\HdomainGridView;
use hipanel\modules\hosting\models\Hdomain;
use hipanel\widgets\Box;
use hipanel\widgets\ModalButton;
use yii\helpers\Html;
use yii\web\JsExpression;

$this->title    = $model->domain;
$this->subtitle = Yii::t('app', 'Hosting domain detailed information') . ' #' . $model->id;
$this->breadcrumbs->setItems([
    ['label' => Yii::t('app', 'Domains'), 'url' => ['index']],
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
                    <?php $url = 'http://' . $model->domain . '/' ?>
                    <?= Html::a('<i class="fa fa-globe"></i>' . Yii::t('app', 'Go to site ') . $url, $url, ['target' => '_blank']); ?>
                </li>
                <li>
                    <?= Html::a('<i class="fa fa-pencil"></i>' . Yii::t('app', 'Advanced settings'), ['/hosting/vhost/advanced-config', 'id' => $model->id]); ?>
                </li>
                <?php if (Yii::$app->user->can('support') && Yii::$app->user->id != $model->client_id) { ?>
                    <li>
                        <?= $this->render('_block', compact(['model', 'blockReasons'])); ?>
                    </li>
                <?php } ?>
                <li>
                    <?= ModalButton::widget([
                        'model' => $model,
                        'scenario' => 'delete',
                        'button' => [
                            'label' => '<i class="fa fa-trash-o"></i>' . Yii::t('app', 'Delete'),
                        ],
                        'modal' => [
                            'header' => Html::tag('h4', Yii::t('app', 'Confirm domain deleting')),
                            'headerOptions' => ['class' => 'label-info'],
                            'footer' => [
                                'label' => Yii::t('app', 'Delete domain'),
                                'data-loading-text' => Yii::t('app', 'Deleting domain...'),
                                'class' => 'btn btn-danger',
                            ]
                        ],
                        'body' => Yii::t('app',
                            'Are you sure, that you want to delete hosting domain {name}? All files under domain root on the server will stay untouched. You can delete them manually later.',
                            ['name' => $model->domain]
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
                                'dns_on',
                                [
                                    'attribute' => 'aliases',
                                    'label'     => Yii::t('app', 'Aliases'),
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        $html = [];
                                        foreach ((array)$model->getAttribute('aliases') as $id => $alias) {
                                            $aliasModel = Yii::createObject([
                                                'class' => Hdomain::className(),
                                                'id' => $id,
                                                'domain' => $alias
                                            ]);
                                            $item = Html::a($aliasModel->domain, ['view', 'id' => $aliasModel->id]) . ' ';
                                            $item .= ModalButton::widget([
                                                'model' => $aliasModel,
                                                'scenario' => 'delete-alias',
                                                'submit' => ModalButton::SUBMIT_AJAX,
                                                'button' => [
                                                    'label' => '<i class="fa fa-trash-o"></i>',
                                                ],
                                                'modal' => [
                                                    'header' => Html::tag('h4', Yii::t('app', 'Confirm alias deleting')),
                                                    'headerOptions' => ['class' => 'label-info'],
                                                    'footer' => [
                                                        'label' => Yii::t('app', 'Delete alias'),
                                                        'data-loading-text' => Yii::t('app', 'Deleting alias...'),
                                                        'class' => 'btn btn-danger',
                                                    ]
                                                ],
                                                'body' => Yii::t('app',
                                                    'Are you sure, that you want to delete alias {name}?',
                                                    ['name' => $aliasModel->domain]
                                                ),
                                                'ajaxOptions' => [
                                                    'success' => new JsExpression("
                                                        function (data) {
                                                            form.closest('.alias-item').remove();
                                                        }
                                                    ")
                                                ]
                                            ]);
                                            $html[] = Html::tag('div', $item, ['class' => 'alias-item']);
                                        }
                                        return implode("\n", $html);
                                    }
                                ]
                            ],
                        ]);
                    $box->endBody();
                $box->end();
                ?>
            </div>
        </div>
    </div>
</div>
