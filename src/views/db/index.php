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

echo Html::beginForm();
$box = ActionBox::begin(['bulk' => true, 'options' => ['class' => 'box-info']]);
$box->beginActions();
echo Html::a(Yii::t('app', 'Create {modelClass}', ['modelClass' => 'DB']), ['create'], ['class' => 'btn btn-success']) . '&nbsp;';
echo LinkSorter::widget([
    'show'       => true,
    'sort'       => $dataProvider->getSort(),
    'attributes' => [
        'client', 'account', 'server', 'name', 'description', 'state'
    ],
]);
$box->endActions();

$box->beginBulkActions();
echo Html::submitButton(Yii::t('app', 'Delete'), ['class' => 'btn btn-danger', 'formmethod' => 'POST', 'formaction' => Url::to('delete')]);
$box->endBulkActions();
$box::end();

echo DbGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'checkbox',
        'seller_id',
        'client_id',
        'name',
        'service_ip',
        'description',
        'state',
        'actions'
    ],
]);

Pjax::end();
