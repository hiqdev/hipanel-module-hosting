<?php

use hipanel\modules\dns\widgets\DnsZoneEditWidget;
use hipanel\modules\hosting\grid\HdomainGridView;
use hipanel\modules\hosting\models\Hdomain;
use hipanel\widgets\Box;
use hipanel\widgets\ClientSellerLink;
use hipanel\widgets\ModalButton;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\web\View;

/**
 * @var $this View
 * @var $model Hdomain
 */

$this->title = $model->domain;
$this->subtitle =
    (
        $model->isAlias()
        ? Yii::t('hipanel/hosting', 'Hosting domain alias detailed information')
        : Yii::t('hipanel/hosting', 'Hosting domain detailed information')
    ) . ' #' . $model->id;
$this->breadcrumbs->setItems([
    ['label' => Yii::t('hipanel/hosting', 'Domains'), 'url' => ['index']],
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
            <span class="profile-user-name"><?= ClientSellerLink::widget(compact('model')) ?></span>
        </p>

        <div class="profile-usermenu">
            <ul class="nav">
                <li>
                    <?php $url = 'http://' . $model->domain . '/' ?>
                    <?= Html::a('<i class="fa fa-globe"></i>' . Yii::t('hipanel/hosting', 'Go to site {link}', ['link' => $url]), $url,
                        ['target' => '_blank']); ?>
                </li>
                <?php if (!$model->isAlias()) { ?>
                    <li>
                        <?= Html::a('<i class="fa fa-pencil"></i>' . Yii::t('hipanel/hosting', 'Advanced settings'),
                            ['/hosting/vhost/advanced-config', 'id' => $model->id]); ?>
                    </li>
                <?php } ?>
                <?php if (!$model->isAlias()) { ?>
                <li>
                    <?= Html::a('<i class="fa fa-adjust"></i>' . Yii::t('hipanel/hosting', 'Proxy settings'),
                        ['/hosting/vhost/manage-proxy', 'id' => $model->id]); ?>
                </li>
                <?php } ?>
                <?php if (Yii::$app->user->can('support') && Yii::$app->user->id !== $model->client_id && !$model->isAlias()) : ?>
                    <li>
                        <?= $this->render('_block', compact(['model', 'blockReasons'])) ?>
                    </li>
                <?php endif ?>
                <li>
                    <?= ModalButton::widget([
                        'model' => $model,
                        'scenario' => 'delete',
                        'button' => [
                            'label' => '<i class="fa fa-trash-o"></i>' . Yii::t('hipanel', 'Delete'),
                        ],
                        'modal' => [
                            'header' => Html::tag('h4', Yii::t('hipanel/hosting', 'Confirm domain deleting')),
                            'headerOptions' => ['class' => 'label-info'],
                            'footer' => [
                                'label' => Yii::t('hipanel/hosting', 'Delete domain'),
                                'data-loading-text' => Yii::t('hipanel', 'Deleting...'),
                                'class' => 'btn btn-danger',
                            ]
                        ],
                        'body' => Yii::t('hipanel/hosting',
                            'Are you sure to delete domain {name}? All files under domain root on the server will stay untouched. You can delete them manually later.',
                            ['name' => $model->domain]
                        )
                    ]) ?>
                </li>
            </ul>
        </div>
        <?php Box::end(); ?>
    </div>

    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#hdomain-details" data-toggle="tab"><?= Yii::t('hipanel', 'Details') ?></a></li>
                <li><a href="#hdomain-dns" data-toggle="tab"><?= Yii::t('hipanel', 'DNS records') ?></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="hdomain-details">
                    <?= HdomainGridView::detailView([
                        'boxed' => false,
                        'model' => $model,
                        'columns' => [
                            'client_id', 'seller_id',
                            'account', 'server', 'service',
                            'ip',
                            'state',
                            'dns_switch',
                            [
                                'attribute' => 'aliases',
                                'label' => Yii::t('hipanel', 'Aliases'),
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $html = [];
                                    foreach ((array)$model->getAttribute('aliases') as $id => $alias) {
                                        $aliasModel = Yii::createObject([
                                            'class' => Hdomain::class,
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
                                                'header' => Html::tag('h4', Yii::t('hipanel/hosting', 'Confirm alias deleting')),
                                                'headerOptions' => ['class' => 'label-info'],
                                                'footer' => [
                                                    'label' => Yii::t('hipanel/hosting', 'Delete alias'),
                                                    'data-loading-text' => Yii::t('hipanel', 'Deleting...'),
                                                    'class' => 'btn btn-danger',
                                                ]
                                            ],
                                            'body' => Yii::t('hipanel/hosting',
                                                'Are you sure to delete alias {name}?',
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
                            ],
                            'backups_widget',
                        ],
                    ]); ?>
                </div>
                <div class="tab-pane" id="hdomain-dns">
                    <?php echo DnsZoneEditWidget::widget([
                        'domainId' => $model->getDnsId(),
                        'clientScriptWrap' => function ($js) {
                            return new \yii\web\JsExpression("
                                $('a[data-toggle=tab]').filter(function () {
                                    return $(this).attr('href') == '#hdomain-dns';
                                }).on('shown.bs.tab', function (e) {
                                    $js
                                });
                            ");
                        }
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
