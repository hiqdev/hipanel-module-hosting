<?php

use hipanel\modules\hosting\grid\HdomainGridLegend;
use hipanel\modules\hosting\grid\HdomainGridView;
use hipanel\widgets\AjaxModal;
use hipanel\widgets\gridLegend\GridLegend;
use hipanel\widgets\IndexPage;
use hipanel\widgets\Pjax;
use yii\bootstrap\Dropdown;
use yii\helpers\Html;

$this->title = Yii::t('hipanel', 'Domains');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
    <?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>

        <?= $page->setSearchFormData(compact(['stateData', 'typeData'])) ?>

        <?php $page->beginContent('main-actions') ?>
            <div class="dropdown">
                <a class="btn btn-sm btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <?= Yii::t('hipanel:hosting', 'Create domain') ?>
                    <span class="caret"></span>
                </a>
                <?= Dropdown::widget([
                    'items' => [
                        ['label' => Yii::t('hipanel:hosting', 'Create domain'), 'url' => ['create']],
                        ['label' => Yii::t('hipanel:hosting', 'Create alias'), 'url' => ['create-alias']],
                    ],
                ]) ?>
            </div>
            <?php if (Yii::getAlias('@certificate', false) && Yii::$app->user->can('certificate.pay') && Yii::$app->user->can('test.beta')) : ?>
                <?= Html::a(Yii::t('hipanel:certificate', 'Buy certificate'), ['@certificate/order/index'], ['class' => 'btn btn-sm btn-success']) ?>
            <?php endif ?>
        <?php $page->endContent() ?>

        <?php $page->begincontent('legend') ?>
            <?= GridLegend::widget(['legendItem' => new HdomainGridLegend($model)]) ?>
        <?php $page->endcontent() ?>

        <?php $page->beginContent('sorter-actions') ?>
            <?= $page->renderSorter([
                'attributes' => [
                    'domain', 'client', 'seller',
                    'account', 'server', 'state',
                ],
            ]) ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('bulk-actions') ?>
            <?php if (Yii::$app->user->can('support')) : ?>
                <div class="dropdown" style="display: inline-block">
                    <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= Yii::t('hipanel', 'Block') ?>
                        <span class="caret"></span>
                    </button>
                    <?= Dropdown::widget([
                        'encodeLabels' => false,
                        'options' => ['class' => 'pull-right'],
                        'items' => [
                            [
                                'label' => '<i class="fa fa-toggle-on"></i> ' . Yii::t('hipanel', 'Enable'),
                                'linkOptions' => ['data-toggle' => 'modal'],
                                'url' => '#bulk-enable-block-modal',
                            ],
                            [
                                'label' => '<i class="fa fa-toggle-off"></i> ' . Yii::t('hipanel', 'Disable'),
                                'url' => '#bulk-disable-block-modal',
                                'linkOptions' => ['data-toggle' => 'modal'],
                            ],
                        ],
                    ]) ?>
                    <div>
                        <?= AjaxModal::widget([
                            'id' => 'bulk-enable-block-modal',
                            'bulkPage' => true,
                            'header'=> Html::tag('h4', Yii::t('hipanel:hosting', 'Block domains'), ['class' => 'modal-title']),
                            'scenario' => 'bulk-enable-block',
                            'actionUrl' => ['bulk-enable-block-modal'],
                            'size' => AjaxModal::SIZE_LARGE,
                            'handleSubmit' => false,
                            'toggleButton' => false,
                        ]) ?>
                        <?= AjaxModal::widget([
                            'id' => 'bulk-disable-block-modal',
                            'bulkPage' => true,
                            'header'=> Html::tag('h4', Yii::t('hipanel:hosting', 'Unblock domains'), ['class' => 'modal-title']),
                            'scenario' => 'bulk-disable-block',
                            'actionUrl' => ['bulk-disable-block-modal'],
                            'size' => AjaxModal::SIZE_LARGE,
                            'handleSubmit' => false,
                            'toggleButton' => false,
                        ]) ?>
                    </div>
                </div>
            <?php endif ?>
            <?= $page->renderBulkDeleteButton('delete')?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('table') ?>
            <?php $page->beginBulkForm() ?>
                <?= HdomainGridView::widget([
                    'boxed' => false,
                    'dataProvider' => $dataProvider,
                    'filterModel'  => $model,
                    'rowOptions' => function ($model) {
                        return GridLegend::create(new HdomainGridLegend($model))->gridRowOptions();
                    },
                    'columns' => $representationCollection->getByName($uiModel->representation)->getColumns(),
                ]) ?>
            <?php $page->endBulkForm() ?>
        <?php $page->endContent() ?>
    <?php $page->end() ?>
<?php Pjax::end() ?>
