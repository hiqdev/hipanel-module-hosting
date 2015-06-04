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

$this->title                    = Yii::t('app', 'Domains');
$this->params['breadcrumbs'][]  = $this->title;
$this->params['subtitle']       = Yii::$app->request->queryParams ? 'filtered list' : 'full list';

Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true]));

$box = ActionBox::begin(['options' => ['class' => 'box-info']]);
$box->beginActions();
echo Html::a(Yii::t('app', 'Create {modelClass}', ['modelClass' => 'domain']), ['create'], ['class' => 'btn btn-success']) . '&nbsp;';
$box->endActions();
$box::end();

echo HdomainGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'checkbox',
        'seller_id',
        'client_id',
        'account',
        'server',
        'hdomain',
        'ip',
        'service',
        'actions'
    ],
]);

Pjax::end();