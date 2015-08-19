<?php

use hipanel\modules\hosting\grid\DbGridView;
use hipanel\widgets\ActionBox;
use hipanel\widgets\Pjax;

$this->title                   = Yii::t('app', 'Databases');
$this->breadcrumbs->setItems([$this->title]);
$this->params['subtitle']       = Yii::$app->request->queryParams ? 'filtered list' : 'full list';

Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])); ?>

<?php $box = ActionBox::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>
    <?php $box->beginActions() ?>
        <?= $box->renderCreateButton(Yii::t('app', 'Create {modelClass}', ['modelClass' => 'DB'])) . '&nbsp;' ?>
        <?= $box->renderSearchButton(); ?>
        <?= $box->renderSorter([
            'attributes' => [
                'client', 'account', 'server', 'name', 'description', 'state'
            ],
        ]) ?>
        <?= $box->renderPerPage() ?>
    <?php $box->endActions() ?>
    <?php $box->beginBulkActions() ?>
        <?= $box->renderDeleteButton() ?>
    <?php $box->endBulkActions() ?>
        <?= $box->renderSearchForm(['stateData' => $stateData]) ?>
    <?php $box->end() ?>

    <?php $box->beginBulkForm() ?>
        <?= DbGridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'  => $model,
            'columns'      => [
                'checkbox',
                'name',
                'client',
                'seller',
                'server',
                'service_ip',
                'description',
                'state',
                'actions'
            ],
        ]) ?>
    <?php $box->endBulkForm() ?>
<?php Pjax::end();
