<?php

use hipanel\modules\hosting\grid\BackupGridView;
use hipanel\modules\hosting\models\BackupSearch;
use hipanel\widgets\IndexPage;
use hiqdev\hiart\ActiveDataProvider;
use yii\web\View;


/**
 * @var View $this
 * @var BackupSearch $model
 * @var ActiveDataProvider $dataProvider
 * @var array $objectOptions
 */

$this->title = Yii::t('hipanel', 'Backups');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $page = IndexPage::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>

    <?php $page->setSearchFormData(['objectOptions' => $objectOptions]) ?>

    <?php $page->beginContent('main-actions') ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('sort-actions') ?>
        <?= $page->renderSorter([
            'attributes' => [
                'client', 'account',
                'server', 'object',
                'id', 'time',
            ],
        ]) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('bulk-actions') ?>
        <?= $page->renderBulkDeleteButton('delete')?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('table') ?>
        <?php $page->beginBulkForm() ?>
            <?= BackupGridView::widget([
                'boxed' => false,
                'dataProvider' => $dataProvider,
                'filterModel' => $model,
                'columns' => [
                    'checkbox', 'id',
                    'object_id', 'object',
                    'client', 'account', 'server',
                    'time', 'size',
                    'actions',
                ],
            ]) ?>
        <?php $page->endBulkForm() ?>
    <?php $page->endContent() ?>
<?php $page->end() ?>
