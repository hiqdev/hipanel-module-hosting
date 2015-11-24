<?php

use hipanel\modules\hosting\grid\DbGridView;
use hipanel\widgets\ActionBox;
use hipanel\widgets\Pjax;

$this->title                   = Yii::t('app', 'Databases');
$this->breadcrumbs->setItems([$this->title]);
$this->params['subtitle']       = array_filter(Yii::$app->request->get($model->formName(), [])) ? 'filtered list' : 'full list';

Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])); ?>

<?php $box = ActionBox::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>
    <?php $box->beginActions() ?>
        <?= $box->renderCreateButton(Yii::t('hipanel/hosting', 'Create DB')) . '&nbsp;' ?>
        <?= $box->renderSearchButton(); ?>
        <?= $box->renderSorter([
            'attributes' => [
                'client', 'seller', 'account', 'server', 'name', 'description', 'state'
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
                'account',
                'server',
                'client_id',
                'seller_id',
                'description',
                'state',
                'actions'
            ],
        ]) ?>
    <?php $box->endBulkForm() ?>
<?php Pjax::end();
