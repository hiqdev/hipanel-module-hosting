<?php

use hipanel\modules\hosting\grid\MailGridLegend;
use hipanel\modules\hosting\grid\MailGridView;
use hipanel\widgets\gridLegend\GridLegend;
use hipanel\widgets\IndexPage;
use hipanel\widgets\Pjax;
use yii\helpers\Html;

$this->title = Yii::t('hipanel:hosting', 'Mailboxes');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
    <?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>

        <?php $page->setSearchFormData(compact(['stateData', 'typeData'])) ?>

        <?php $page->beginContent('legend') ?>
            <?= GridLegend::widget(['legendItem' => new MailGridLegend($model)]) ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('main-actions') ?>
            <?= Html::a(Yii::t('hipanel:hosting', 'Create mailbox'), 'create', ['class' => 'btn btn-sm btn-success']) ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('sorter-actions') ?>
            <?= $page->renderSorter([
                'attributes' => [
                    'client', 'seller', 'account',
                    'state', 'server', 'mail',
                ],
            ]) ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('bulk-actions') ?>
            <?= $page->renderBulkButton(Yii::t('hipanel', 'Enable'), 'enable') ?>
            <?= $page->renderBulkButton(Yii::t('hipanel', 'Disable'), 'disable') ?>
            <?= $page->renderBulkButton(Yii::t('hipanel', 'Delete'), 'delete', 'danger')?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('table') ?>
            <?php $page->beginBulkForm() ?>
                <?= MailGridView::widget([
                    'boxed' => false,
                    'dataProvider' => $dataProvider,
                    'filterModel' => $model,
                    'rowOptions' => function ($model) {
                        return GridLegend::create(new MailGridLegend($model))->gridRowOptions();
                    },
                    'columns' => $representationCollection->getByName($uiModel->representation)->getColumns(),
                ]) ?>
            <?php $page->endBulkForm() ?>
        <?php $page->endContent() ?>
    <?php $page->end() ?>
<?php Pjax::end() ?>
