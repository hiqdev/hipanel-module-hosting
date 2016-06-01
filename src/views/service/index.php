<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\ServiceGridView;
use hipanel\widgets\ActionBox;
use hipanel\widgets\IndexLayoutSwitcher;
use hipanel\widgets\IndexPage;
use hipanel\widgets\Pjax;
use yii\helpers\Html;

$this->title                    = Yii::t('hipanel/hosting', 'Services');
$this->params['breadcrumbs'][]  = $this->title;
$this->subtitle = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
    <?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>

        <?= $page->setSearchFormData(compact(['stateData', 'typeData'])) ?>

        <?php $page->beginContent('main-actions') ?>
            <?= Html::a(Yii::t('hipanel/hosting', 'Create service'), 'create', ['class' => 'btn btn-sm btn-success']) ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('show-actions') ?>
        <?= IndexLayoutSwitcher::widget() ?>
        <?= $page->renderSorter([
            'attributes' => [
                'client',
                'seller',
                'name',
                'soft',
            ],
        ]) ?>
        <?= $page->renderPerPage() ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('bulk-actions') ?>
            <?= $page->renderBulkButton(Yii::t('hipanel/hosting', 'Delete'), 'delete', 'danger')?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('table') ?>
        <?php $page->beginBulkForm() ?>
            <?= ServiceGridView::widget([
                'dataProvider' => $dataProvider,
                'boxed' => false,
                'filterModel'  => $model,
                'columns'      => [
                    'checkbox',
                    'seller_id',
                    'client_id',
                    'server',
                    'object',
                    'ip',
                    'soft',
                    'state',
                    'actions',
                ],
            ]) ?>
        <?php $page->endBulkForm() ?>
        <?php $page->endContent() ?>
    <?php $page->end() ?>
<?php Pjax::end() ?>
