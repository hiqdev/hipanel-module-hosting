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
$box = ActionBox::begin(['model' => $model, 'options' => ['class' => 'box-info']]);
$box->beginActions();
print $box->renderCreateButton(Yii::t('app', 'Create {modelClass}', ['modelClass' => Yii::t('app', 'Domain')]));
echo '&nbsp;';
print $box->renderSearchButton();
$box->endActions();

$box->beginBulkActions();
echo Html::submitButton(Yii::t('app', 'Delete'), ['class' => 'btn btn-danger', 'formmethod' => 'POST', 'formaction' => Url::to('delete')]);
$box->endBulkActions();
print $box->renderSearchForm();
$box::end();
$box->beginBulkForm();
echo HdomainGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'checkbox',
        'hdomain',
        'client_id',
        'seller_id',
        'account',
        'server',
        'state',
        'ip',
        'service',
        'actions',
    ],
]);
$box::endBulkForm();
Pjax::end();