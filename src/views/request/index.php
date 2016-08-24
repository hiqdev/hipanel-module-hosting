<?php

use hipanel\modules\hosting\grid\RequestGridView;
use hipanel\widgets\IndexPage;
use hipanel\widgets\Pjax;

$this->title = Yii::t('hipanel/hosting', 'Requests');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][]  = $this->title;

?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
    <?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>

        <?php $page->setSearchFormData(compact('objects', 'states')) ?>

        <?php $page->beginContent('main-actions') ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('show-actions') ?>
            <?= $page->renderLayoutSwitcher() ?>
            <?= $page->renderSorter([
                'attributes' => [
                    'server', 'time', 'state',
                ],
            ]) ?>
            <?= $page->renderPerPage() ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('bulk-actions') ?>
            <?= $page->renderBulkButton(Yii::t('hipanel', 'Delete'), 'delete', 'danger') ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('table') ?>
            <?php $page->beginBulkForm() ?>
                <?= RequestGridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel'  => $model,
                    'boxed' => false,
                    'columns'      => [
                        'checkbox', 'classes',
                        'server', 'account',
                        'object', 'time', 'state',
                        'actions',
                    ],
                ]) ?>
            <?php $page->endBulkForm() ?>
        <?php $page->endContent() ?>
    <?php $page->end() ?>
<?php Pjax::end() ?>
