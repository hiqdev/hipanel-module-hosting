<?php

/*
 * Client Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

use hipanel\modules\hosting\grid\AccountGridView;
use hipanel\widgets\AjaxModal;
use hipanel\widgets\IndexPage;
use hipanel\widgets\Pjax;
use yii\bootstrap\Dropdown;
use yii\helpers\Html;

$this->title = Yii::t('hipanel:hosting', 'Accounts');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
    <?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>

        <?php $page->setSearchFormData(compact(['stateData', 'typeData'])) ?>

        <?php $page->beginContent('main-actions') ?>
            <div class="dropdown">
                <a class="btn btn-sm btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="true">
                    <?= Yii::t('hipanel:hosting', 'Create account'); ?>
                    <span class="caret"></span>
                </a>
                <?= Dropdown::widget([
                    'encodeLabels' => false,
                    'items' => [
                        [
                            'label' => '<i class="fa fa-terminal"></i> ' . Yii::t('hipanel:hosting:account', 'Create SSH account'),
                            'linkOptions' => ['data-toggle' => 'modal'],
                            'url' => '#create-ssh-account-modal',
                        ],
                        [
                            'label' => '<i class="fa fa-upload"></i> ' . Yii::t('hipanel:hosting:account', 'Create FTP account'),
                            'linkOptions' => ['data-toggle' => 'modal'],
                            'url' => '#create-ftp-account-modal',
                        ],
                    ]
                ]); ?>
            </div>
            <div class="text-left">
                <?= AjaxModal::widget([
                    'id' => 'create-ssh-account-modal',
                    'bulkPage' => true,
                    'header' => Html::tag('h4', Yii::t('hipanel:hosting:account', 'Create SSH account'), ['class' => 'modal-title']),
                    'headerOptions' => ['class' => 'label-info'],
                    'scenario' => 'create',
                    'actionUrl' => ['create'],
                    'handleSubmit' => false,
                    'toggleButton' => false,
                ]) ?>
                <?= AjaxModal::widget([
                    'id' => 'create-ftp-account-modal',
                    'bulkPage' => true,
                    'header' => Html::tag('h4', Yii::t('hipanel:hosting:account', 'Create FTP account'), ['class' => 'modal-title']),
                    'headerOptions' => ['class' => 'label-info'],
                    'scenario' => 'create-ftponly',
                    'actionUrl' => ['create-ftponly'],
                    'handleSubmit' => false,
                    'toggleButton' => false,
                ]) ?>
            </div>
        <?php $page->endContent() ?>

        <?php $page->beginContent('show-actions') ?>
            <?= $page->renderLayoutSwitcher() ?>
            <?= $page->renderSorter([
                'attributes' => [
                    'login', 'client', 'seller',
                    'server', 'state', 'type'
                ],
            ]) ?>
            <?= $page->renderPerPage() ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('bulk-actions') ?>
            <?php
            $dropDownItems = [
                [
                    'label' => '<i class="fa fa-trash"></i> ' . Yii::t('hipanel', 'Delete'),
                    'url' => '#bulk-delete-modal',
                    'linkOptions' => ['data-toggle' => 'modal']
                ],
            ];
            $ajaxModals = [
                [
                    'id' => 'bulk-delete-modal',
                    'bulkPage' => true,
                    'header' => Html::tag('h4', Yii::t('hipanel', 'Delete'), ['class' => 'modal-title label-danger']),
                    'headerOptions' => ['class' => 'label-danger'],
                    'scenario' => 'delete',
                    'actionUrl' => ['bulk-delete-modal'],
                    'handleSubmit' => false,
                    'toggleButton' => false,
                ]
            ];
            if (Yii::$app->user->can('support')) {
                array_unshift($dropDownItems, [
                    'label' => '<i class="fa fa-toggle-on"></i> ' . Yii::t('hipanel', 'Enable block'),
                    'linkOptions' => ['data-toggle' => 'modal'],
                    'url' => '#bulk-enable-block-modal',
                ],[
                    'label' => '<i class="fa fa-toggle-off"></i> ' . Yii::t('hipanel', 'Disable block'),
                    'url' => '#bulk-disable-block-modal',
                    'linkOptions' => ['data-toggle' => 'modal'],

                ]);
                array_unshift($ajaxModals, [
                    'id' => 'bulk-disable-block-modal',
                    'bulkPage' => true,
                    'header' => Html::tag('h4', Yii::t('hipanel:hosting', 'Unblock accounts'), ['class' => 'modal-title']),
                    'headerOptions' => ['class' => 'label-warning'],
                    'scenario' => 'bulk-disable-block',
                    'actionUrl' => ['bulk-disable-block-modal'],
                    'handleSubmit' => false,
                    'toggleButton' => false,
                ],[
                    'id' => 'bulk-enable-block-modal',
                    'bulkPage' => true,
                    'header' => Html::tag('h4', Yii::t('hipanel:hosting', 'Block accounts'), ['class' => 'modal-title']),
                    'headerOptions' => ['class' => 'label-warning'],
                    'scenario' => 'bulk-enable-block',
                    'actionUrl' => ['bulk-enable-block-modal'],
                    'handleSubmit' => false,
                    'toggleButton' => false,
                ]);
            }
            ?>
            <div class="dropdown" style="display: inline-block">
                <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= Yii::t('hipanel', 'Basic actions') ?>
                    <span class="caret"></span>
                </button>
                <?= Dropdown::widget([
                    'encodeLabels' => false,
                    'options' => ['class' => 'pull-right'],
                    'items' => $dropDownItems,
                ]) ?>
                <div class="text-left">
                    <?php foreach ($ajaxModals as $ajaxModal) : ?>
                        <?= AjaxModal::widget($ajaxModal) ?>
                    <?php endforeach ?>
               </div>
            </div>
        <?php $page->endContent() ?>

        <?php $page->beginContent('table') ?>
            <?php $page->beginBulkForm() ?>
                <?= AccountGridView::widget([
                    'boxed' => false,
                    'dataProvider' => $dataProvider,
                    'filterModel' => $model,
                    'columns' => [
                        'checkbox',
                        'account', 'client', 'seller',
                        'server', 'state', 'type',
                    ],
                ]) ?>
            <?php $page->endBulkForm() ?>
        <?php $page->endContent() ?>
    <?php $page->end() ?>
<?php Pjax::end() ?>
