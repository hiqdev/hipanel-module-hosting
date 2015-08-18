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
$box = ActionBox::begin(['model' => $model, 'dataProvider' => $dataProvider]);
$box->beginActions();
?>
    <div class="dropdown">
        <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <?= Yii::t('app', 'Create accaunt'); ?>&nbsp;
            <span class="caret"></span>
        </button>
        <?= $box->renderSearchButton(); ?>
        <?= $box->renderSorter([
            'attributes' => [
                'login', 'client', 'server', 'state', 'type'
            ],
        ]) ?>
        <?= $box->renderPerPage() ?>
        <?= \yii\bootstrap\Dropdown::widget([
            'items' => [
                ['label' => Yii::t('app', 'Create {modelClass}', ['modelClass' => 'account']), 'url' => ['create']],
                ['label' => Yii::t('app', 'Create FTP {modelClass}', ['modelClass' => 'account']), 'url' => ['create-ftponly']],
            ]
        ]) . '&nbsp;'; ?>
    </div>

<?php
$box->endActions();

$box->beginBulkActions();
echo Html::submitButton(Yii::t('app', 'Delete'), ['class' => 'btn btn-danger', 'formmethod' => 'POST', 'formaction' => Url::to('delete')]);
$box->endBulkActions();
print $box->renderSearchForm();
$box::end();

$box->beginBulkForm();
echo AccountGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'checkbox',
        'account',
        'client',
        'seller',
        'server',
        'state',
        'actions',
    ],
]);
$box::endBulkForm();

Pjax::end();
