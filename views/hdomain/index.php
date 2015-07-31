<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\HdomainGridView;
use hipanel\widgets\ActionBox;
use hipanel\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title                    = Yii::t('app', 'Domains');
$this->breadcrumbs->setItems([
    $this->title,
]);
$this->params['subtitle']       = Yii::$app->request->queryParams ? 'filtered list' : 'full list';

Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true]));


echo Html::beginForm();
$box = ActionBox::begin(['bulk' => true, 'options' => ['class' => 'box-info']]);
$box->beginActions();
echo Html::a(Yii::t('app', 'Create {modelClass}', ['modelClass' => Yii::t('app', 'Domain')]), ['create'], ['class' => 'btn btn-primary']);
echo '&nbsp;';
$box->endActions();

$box->beginBulkActions();
echo Html::submitButton(Yii::t('app', 'Delete'), ['class' => 'btn btn-danger', 'formmethod' => 'POST', 'formaction' => Url::to('delete')]);
$box->endBulkActions();
$box::end();

echo HdomainGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'hdomain',
        'account',
        'server',
        'client_id',
        'seller_id',
        'state',
        'ip',
        'service',
        'actions',
        'checkbox',
    ],
]);

Pjax::end();