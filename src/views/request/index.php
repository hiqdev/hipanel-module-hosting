<?php

use hipanel\models\IndexPageUiOptions;
use hipanel\modules\hosting\grid\RequestGridLegend;
use hipanel\modules\hosting\grid\RequestGridView;
use hipanel\modules\hosting\grid\RequestRepresentations;
use hipanel\modules\hosting\models\RequestSearch;
use hipanel\widgets\gridLegend\GridLegend;
use hipanel\widgets\IndexPage;
use hiqdev\hiart\ActiveDataProvider;
use yii\web\View;

/**
 * @var View $this
 * @var RequestSearch $model
 * @var ActiveDataProvider $dataProvider
 * @var IndexPageUiOptions $uiModel
 * @var RequestRepresentations $representationCollection
 * @var array $objects
 * @var array $states
 */

$this->title = Yii::t('hipanel:hosting', 'Requests');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][]  = $this->title;

?>

<?php $page = IndexPage::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>

    <?php $page->setSearchFormData(['objects' => $objects, 'states' => $states]) ?>

    <?php $page->beginContent('legend') ?>
        <?= GridLegend::widget(['legendItem' => new RequestGridLegend($model)]) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('sorter-actions') ?>
        <?= $page->renderSorter([
            'attributes' => [
                'server', 'time', 'state',
            ],
        ]) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('bulk-actions') ?>
        <?= $page->renderBulkDeleteButton('delete') ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('table') ?>
        <?php $page->beginBulkForm() ?>
            <?= RequestGridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'  => $model,
                'boxed' => false,
                'colorize' => true,
                'columns' => $representationCollection->getByName($uiModel->representation)->getColumns(),
            ]) ?>
        <?php $page->endBulkForm() ?>
    <?php $page->endContent() ?>
<?php $page->end() ?>
