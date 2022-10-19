<?php

use hipanel\models\IndexPageUiOptions;
use hipanel\modules\hosting\grid\MailGridLegend;
use hipanel\modules\hosting\grid\MailGridView;
use hipanel\modules\hosting\grid\MailRepresentations;
use hipanel\modules\hosting\models\MailSearch;
use hipanel\widgets\gridLegend\GridLegend;
use hipanel\widgets\IndexPage;
use hiqdev\hiart\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var MailSearch $model
 * @var ActiveDataProvider $dataProvider
 * @var IndexPageUiOptions $uiModel
 * @var MailRepresentations $representationCollection
 * @var array $stateData
 * @var array $typeData
 */

$this->title = Yii::t('hipanel:hosting', 'Mailboxes');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $page = IndexPage::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>

    <?php $page->setSearchFormData(['stateData' => $stateData, 'typeData' => $typeData]) ?>

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
        <?= $page->renderBulkButton('enable', Yii::t('hipanel', 'Enable')) ?>
        <?= $page->renderBulkButton('disable', Yii::t('hipanel', 'Disable')) ?>
        <?= $page->renderBulkDeleteButton('delete')?>
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
