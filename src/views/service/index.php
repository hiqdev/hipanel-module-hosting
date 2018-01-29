<?php

use hipanel\modules\hosting\grid\ServiceGridView;
use hipanel\widgets\IndexPage;
use hipanel\widgets\Pjax;
use yii\helpers\Html;

$this->title = Yii::t('hipanel:hosting', 'Services');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][]  = $this->title;

?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
    <?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>

        <?php $page->setSearchFormData(compact(['stateData', 'softData'])) ?>
        <?php $page->beginContent('main-actions') ?>
            <?php if (Yii::$app->user->can('admin')) : ?>
                <?= Html::a(Yii::t('hipanel:hosting', 'Create service'), 'create', ['class' => 'btn btn-sm btn-success']) ?>
            <?php endif ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('sorter-actions') ?>
            <?= $page->renderSorter([
                'attributes' => [
                    'client', 'seller',
                    'name', 'soft',
                ],
            ]) ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('bulk-actions') ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('table') ?>
            <?php $page->beginBulkForm() ?>
                <?= ServiceGridView::widget([
                    'dataProvider' => $dataProvider,
                    'boxed' => false,
                    'filterModel' => $model,
                    'columns' => $representationCollection->getByName($uiModel->representation)->getColumns(),
                ]) ?>
            <?php $page->endBulkForm() ?>
        <?php $page->endContent() ?>
    <?php $page->end() ?>
<?php Pjax::end() ?>
