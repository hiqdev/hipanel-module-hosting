<?php

use hipanel\models\IndexPageUiOptions;
use hipanel\modules\hosting\grid\DbGridView;
use hipanel\modules\hosting\grid\DbRepresentations;
use hipanel\modules\hosting\models\DbSearch;
use hipanel\widgets\IndexPage;
use hiqdev\hiart\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var DbSearch $model
 * @var ActiveDataProvider $dataProvider
 * @var IndexPageUiOptions $uiModel
 * @var DbRepresentations $representationCollection
 * @var array $stateData
 */

$this->title = Yii::t('hipanel', 'Databases');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>

    <?php $page->setSearchFormData(['stateData' => $stateData]) ?>

    <?php $page->beginContent('main-actions') ?>
        <?= Html::a(Yii::t('hipanel:hosting', 'Create DB'), 'create', ['class' => 'btn btn-sm btn-success']) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('sorter-actions') ?>
        <?= $page->renderSorter([
            'attributes' => [
                'client', 'seller', 'account', 'server',
                'name', 'description', 'state',
            ],
        ]) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('bulk-actions') ?>
        <?= $page->renderBulkDeleteButton('delete')?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('table') ?>
        <?php $page->beginBulkForm() ?>
            <?= DbGridView::widget([
                'boxed' => false,
                'dataProvider' => $dataProvider,
                'filterModel'  => $model,
                'columns' => $representationCollection->getByName($uiModel->representation)->getColumns(),
            ]) ?>
        <?php $page->endBulkForm() ?>
    <?php $page->endContent() ?>
<?php $page->end() ?>
