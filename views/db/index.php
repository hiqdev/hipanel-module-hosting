<?php

use hipanel\modules\hosting\grid\DbGridView;
use hipanel\widgets\ActionBox;
use hipanel\widgets\Pjax;
use yii\helpers\Html;

$this->title                   = Yii::t('app', 'Databases');
$this->params['breadcrumbs'][] = $this->title;
$this->params['subtitle']      = Yii::$app->request->queryParams ? 'filtered list' : 'full list';

Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true]));

$box = ActionBox::begin(['options' => ['class' => 'box-info']]);
$box->beginActions();
echo Html::a(Yii::t('app', 'Create {modelClass}', ['modelClass' => 'DB']), ['create'], ['class' => 'btn btn-success']) . '&nbsp;';
$box->endActions();
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
