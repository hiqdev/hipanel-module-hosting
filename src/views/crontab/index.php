<?php

use hipanel\models\IndexPageUiOptions;
use hipanel\modules\hosting\grid\CrontabGridView;
use hipanel\modules\hosting\grid\CrontabRepresentations;
use hipanel\modules\hosting\models\Crontab;
use hipanel\widgets\IndexPage;
use hiqdev\hiart\ActiveDataProvider;
use yii\web\View;

/**
 * @var View $this
 * @var Crontab $model
 * @var ActiveDataProvider $dataProvider
 * @var IndexPageUiOptions $uiModel
 * @var CrontabRepresentations $representationCollection
 */

$this->title = Yii::t('hipanel:hosting', 'Crons');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $page = IndexPage::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>

    <?php $page->beginContent('main-actions') ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('sorter-actions') ?>
        <?= $page->renderSorter([
            'attributes' => [
                'account',
                'client',
                'server',
            ],
        ]) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('bulk-actions') ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('table') ?>
        <?php $page->beginBulkForm() ?>
            <?= CrontabGridView::widget([
                'boxed' => false,
                'dataProvider' => $dataProvider,
                'filterModel' => $model,
                'columns' => $representationCollection->getByName($uiModel->representation)->getColumns(),
            ]) ?>
        <?php $page->endBulkForm() ?>
    <?php $page->endContent() ?>
<?php $page->end() ?>
