<?php

use hipanel\models\IndexPageUiOptions;
use hipanel\modules\hosting\grid\ServiceGridView;
use hipanel\modules\hosting\grid\ServiceRepresentations;
use hipanel\modules\hosting\models\ServiceSearch;
use hipanel\widgets\IndexPage;
use hiqdev\hiart\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var ServiceSearch $model
 * @var ActiveDataProvider $dataProvider
 * @var IndexPageUiOptions $uiModel
 * @var ServiceRepresentations $representationCollection
 * @var array $stateData
 * @var array $softData
 */

$this->title = Yii::t('hipanel:hosting', 'Services');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][]  = $this->title;

?>

<?php $page = IndexPage::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>

    <?php $page->setSearchFormData(['stateData' => $stateData, 'softData' => $softData]) ?>
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
