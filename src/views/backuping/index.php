<?php

use hipanel\models\IndexPageUiOptions;
use hipanel\modules\hosting\grid\BackupingGridView;
use hipanel\modules\hosting\grid\BackupingRepresentations;
use hipanel\modules\hosting\models\BackupingSearch;
use hipanel\widgets\IndexPage;
use hiqdev\hiart\ActiveDataProvider;
use yii\web\View;

/**
 * @var View $this
 * @var BackupingSearch $model
 * @var ActiveDataProvider $dataProvider
 * @var IndexPageUiOptions $uiModel
 * @var BackupingRepresentations $representationCollection
 * @var array $stateOptions
 */

$this->title = Yii::t('hipanel:hosting', 'Backup statistics');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $page = IndexPage::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>

    <?php $page->setSearchFormData(compact(['stateOptions'])) ?>

    <?php $page->beginContent('main-actions') ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('sorter-actions') ?>
        <?= $page->renderSorter([
            'attributes' => [
                'client', 'account',
                'server', 'name',
            ],
        ]) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('bulk-actions') ?>
        <?= $page->renderBulkButton('enable', Yii::t('hipanel', 'Enable')) ?>
        <?= $page->renderBulkButton('disable', Yii::t('hipanel', 'Disable')) ?>
        <?= $page->renderBulkDeleteButton('delete')?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('table') ?>
        <?php $page->beginBulkForm() ?>
            <?= BackupingGridView::widget([
                'boxed' => false,
                'dataProvider' => $dataProvider,
                'filterModel' => $model,
                'typeOptions' => $model->typeOptions,
                'columns' => $representationCollection->getByName($uiModel->representation)->getColumns(),
            ]) ?>
        <?php $page->endBulkForm() ?>
    <?php $page->endContent() ?>
<?php $page->end() ?>
