<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\AccountGridView;
use hipanel\widgets\ActionBox;
use hipanel\widgets\LinkSorter;
use hipanel\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title                    = Yii::t('app', 'Accounts');
$this->breadcrumbs->setItems([
    $this->title,
]);
$this->params['subtitle']       = Yii::$app->request->queryParams ? 'filtered list' : 'full list';

Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true]));

echo Html::beginForm();
$box = ActionBox::begin(['bulk' => true, 'options' => ['class' => 'box-info']]);
$box->beginActions();
echo Html::a(Yii::t('app', 'Advanced search'), '#', ['class' => 'btn btn-info search-button']) . '&nbsp;';
echo Html::a(Yii::t('app', 'Create {modelClass}', ['modelClass' => 'account']), ['create'], ['class' => 'btn btn-success']) . '&nbsp;';
echo Html::a(Yii::t('app', 'Create FTP {modelClass}', ['modelClass' => 'account']), ['create-ftponly'], ['class' => 'btn btn-success']) . '&nbsp;';
echo LinkSorter::widget([
    'show'       => true,
    'sort'       => $dataProvider->getSort(),
    'attributes' => [
        'login', 'client', 'server', 'state', 'type'
    ],
]);
$box->endActions();

$box->beginBulkActions();
echo Html::submitButton(Yii::t('app', 'Delete'), ['class' => 'btn btn-danger', 'formmethod' => 'POST', 'formaction' => Url::to('delete')]);
$box->endBulkActions();
echo $this->render('_search', compact('model'));
$box::end();

echo AccountGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'checkbox',
        'account',
        'client_id',
        'seller_id',
        'server',
        'state',
        'actions',
    ],
]);

Pjax::end();