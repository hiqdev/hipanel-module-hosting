<?php

/**
 * Client Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

use hipanel\models\IndexPageUiOptions;
use hipanel\modules\hosting\grid\AccountGridView;
use hipanel\modules\hosting\grid\AccountRepresentations;
use hipanel\modules\hosting\models\AccountSearch;
use hipanel\widgets\AjaxModal;
use hipanel\widgets\IndexPage;
use hiqdev\hiart\ActiveDataProvider;
use yii\bootstrap\Dropdown;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var AccountSearch $model
 * @var IndexPageUiOptions $uiModel
 * @var AccountRepresentations $representationCollection
 * @var ActiveDataProvider $dataProvider
 * @var array $stateData
 * @var array $typeData
 */

$this->title = Yii::t('hipanel:hosting', 'Accounts');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $page = IndexPage::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>

    <?php $page->setSearchFormData(['stateData' => $stateData, 'typeData']) ?>

    <?php $page->beginContent('main-actions') ?>
        <div class="dropdown">
            <a class="btn btn-sm btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true">
                <?= Yii::t('hipanel:hosting', 'Create account'); ?>
                <span class="caret"></span>
            </a>
            <?= Dropdown::widget([
                'items' => [
                    ['label' => Yii::t('hipanel:hosting', 'Create account'), 'url' => ['create']],
                    ['label' => Yii::t('hipanel:hosting', 'Create FTP account'), 'url' => ['create-ftponly']],
                ],
            ]); ?>
        </div>
    <?php $page->endContent() ?>

    <?php $page->beginContent('sorter-actions') ?>
        <?= $page->renderSorter([
            'attributes' => [
                'login', 'client', 'seller',
                'server', 'state', 'type',
            ],
        ]) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('bulk-actions') ?>
        <?php
        $dropDownItems = [
            [
                'label' => '<i class="fa fa-trash"></i>' . Yii::t('hipanel', 'Delete'),
                'url' => '#bulk-delete-modal',
                'linkOptions' => ['data-toggle' => 'modal'],
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
            ],
        ];
        if (Yii::$app->user->can('support')) {
            array_unshift($dropDownItems, [
                'label' => '<i class="fa fa-toggle-on"></i>' . Yii::t('hipanel', 'Enable block'),
                'linkOptions' => ['data-toggle' => 'modal'],
                'url' => '#bulk-enable-block-modal',
            ],[
                'label' => '<i class="fa fa-toggle-off"></i>' . Yii::t('hipanel', 'Disable block'),
                'url' => '#bulk-disable-block-modal',
                'linkOptions' => ['data-toggle' => 'modal'],
            ]);
            array_unshift($ajaxModals, [
                'id' => 'bulk-disable-block-modal',
                'bulkPage' => true,
                'header' => Html::tag('h4', Yii::t('hipanel:client', 'Unblock clients'), ['class' => 'modal-title']),
                'headerOptions' => ['class' => 'label-warning'],
                'scenario' => 'bulk-disable-block-modal',
                'handleSubmit' => false,
                'toggleButton' => false,
            ],[
                'id' => 'bulk-enable-block-modal',
                'bulkPage' => true,
                'header' => Html::tag('h4', Yii::t('hipanel:client', 'Block clients'), ['class' => 'modal-title']),
                'headerOptions' => ['class' => 'label-warning'],
                'scenario' => 'bulk-enable-block-modal',
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
                'columns' => $representationCollection->getByName($uiModel->representation)->getColumns(),
            ]) ?>
        <?php $page->endBulkForm() ?>
    <?php $page->endContent() ?>
<?php $page->end() ?>
