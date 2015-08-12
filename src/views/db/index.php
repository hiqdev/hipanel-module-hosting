<?php

use hipanel\modules\hosting\grid\DbGridView;
use hipanel\widgets\ActionBox;
use hipanel\widgets\LinkSorter;
use hipanel\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title                   = Yii::t('app', 'Databases');
$this->breadcrumbs->setItems([$this->title]);
$this->params['subtitle']       = Yii::$app->request->queryParams ? 'filtered list' : 'full list';

Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true]));

$box = ActionBox::begin(['model' => $model, 'dataProvider' => $dataProvider]);
$box->beginActions();
print $box->renderCreateButton(Yii::t('app', 'Create {modelClass}', ['modelClass' => 'DB'])) . '&nbsp;';
print $box->renderSearchButton(); ?>
<?= $box->renderSorter([
    'attributes' => [
        'client', 'account', 'server', 'name', 'description', 'state'
    ],
]) ?>
<?= $box->renderPerPage() ?>
<?php
$box->endActions();

$box->beginBulkActions();
echo Html::submitButton(Yii::t('app', 'Delete'), ['class' => 'btn btn-danger', 'formmethod' => 'POST', 'formaction' => Url::to('delete')]);
$box->endBulkActions();
print $box->renderSearchForm();
$box::end();
$box->beginBulkForm();
echo DbGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'checkbox',
        'name',
        'client_id',
        'seller_id',
        'service_ip',
        'description',
        'state',
        'actions'
    ],
]);
$box::endBulkForm();
Pjax::end();
