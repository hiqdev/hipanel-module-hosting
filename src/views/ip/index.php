<?php

use hipanel\models\IndexPageUiOptions;
use hipanel\modules\hosting\grid\IpGridLegend;
use hipanel\modules\hosting\grid\IpGridView;
use hipanel\modules\hosting\grid\IpRepresentations;
use hipanel\modules\hosting\models\IpSearch;
use hipanel\widgets\gridLegend\GridLegend;
use hipanel\widgets\IndexPage;
use hiqdev\hiart\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var IpSearch $model
 * @var ActiveDataProvider $dataProvider
 * @var IndexPageUiOptions $uiModel
 * @var IpRepresentations $representationCollection
 * @var array $ipTags
 */

$this->title = Yii::t('hipanel:hosting', 'IP addresses');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $page = IndexPage::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>

    <?php $page->setSearchFormData(['ipTags' => $ipTags]) ?>

    <?php $page->beginContent('main-actions') ?>
        <?php if (Yii::$app->user->can('support')) : ?>
            <?= Html::a(Yii::t('hipanel:hosting', 'Create IP'), ['@ip/create'], ['class' => 'btn btn-sm btn-success']) ?>
        <?php endif; ?>
    <?php $page->endContent() ?>

    <?php if (Yii::$app->user->can('support')) : ?>
        <?php $page->beginContent('legend') ?>
            <?= GridLegend::widget(['legendItem' => new IpGridLegend($model)]) ?>
        <?php $page->endContent() ?>
    <?php endif ?>

    <?php $page->beginContent('sorter-actions') ?>
        <?= $page->renderSorter([
            'attributes' => [
                'ip',
            ],
        ]) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('table') ?>
        <?php $page->beginBulkForm() ?>
            <?php echo IpGridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'  => $model,
                'boxed' => false,
                'ipTags' => $ipTags,
                'rowOptions' => function ($model) {
                    return GridLegend::create(new IpGridLegend($model))->gridRowOptions();
                },
                'columns' => $representationCollection->getByName($uiModel->representation)->getColumns(),
            ]) ?>
        <?php $page->endBulkForm() ?>
    <?php $page->endContent() ?>
<?php $page->end() ?>
