<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\CrontabGridView;
use hipanel\widgets\ActionBox;
use hipanel\widgets\IndexLayoutSwitcher;
use hipanel\widgets\IndexPage;
use hipanel\widgets\Pjax;

$this->title = Yii::t('hipanel/hosting', 'Crons');
$this->params['breadcrumbs'][] = $this->title;
$this->subtitle = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');

?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
    <?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>

        <?php $page->beginContent('main-actions') ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('show-actions') ?>
            <?= IndexLayoutSwitcher::widget() ?>
        <?= $page->renderSorter([
            'attributes' => [
                'account',
                'client',
                'server',
            ],
        ]) ?>
        <?= $page->renderPerPage() ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('bulk-actions') ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('table') ?>
        <?php $page->beginBulkForm() ?>
            <?= CrontabGridView::widget([
                'boxed' => false,
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
            //        'checkbox',
                    'crontab',
                    'account',
                    'server',
                    'client',
                    'state',
                    'actions',
                ],
            ]) ?>
        <?php $page->endBulkForm() ?>
        <?php $page->endContent() ?>
    <?php $page->end() ?>
<?php Pjax::end() ?>
