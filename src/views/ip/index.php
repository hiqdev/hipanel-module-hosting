<?php

use hipanel\modules\hosting\grid\IpGridView;
use hipanel\widgets\AjaxModal;
use hipanel\widgets\IndexPage;
use hipanel\widgets\Pjax;
use yii\helpers\Html;
use yii\web\JsExpression;

$this->title = Yii::t('hipanel:hosting', 'IP addresses');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
    <?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>

        <?php $page->setSearchFormData(compact(['ipTags'])) ?>

        <?php $page->beginContent('main-actions') ?>
            <?php if (Yii::$app->user->can('support')) : ?>
                <?= Html::a(Yii::t('hipanel:hosting', 'Create IP'), ['@ip/create'], ['class' => 'btn btn-sm btn-success']) ?>
            <?php endif; ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('show-actions') ?>
            <?= $page->renderLayoutSwitcher() ?>
            <?= $page->renderSorter([
                'attributes' => [
                    'ip'
                ],
            ]) ?>
            <?= $page->renderPerPage() ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('table') ?>
            <?php $page->beginBulkForm() ?>
                <?php echo IpGridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel'  => $model,
                    'boxed' => false,
                    'ipTags' => $ipTags,
                    'columns' => [
                        'ip',
                        'note',
                        'actions',
                        'tags',
                        'counters',
                        'links',
                    ],
                ]) ?>
            <?php $page->endBulkForm() ?>
        <?php $page->endContent() ?>
    <?php $page->end() ?>
<?php Pjax::end() ?>

