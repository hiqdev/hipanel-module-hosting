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
$this->params['subtitle']       = Yii::$app->request->queryParams ? 'filtered list' : 'full list'; ?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])); ?>

<?php $box = ActionBox::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>
    <?php $box->beginActions() ?>
        <div class="dropdown">
            <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <?= Yii::t('app', 'Create account'); ?>
                <span class="caret"></span>
            </button>
            <?= \yii\bootstrap\Dropdown::widget([
                'items' => [
                    ['label' => Yii::t('app', 'Create account'), 'url' => ['create']],
                    ['label' => Yii::t('app', 'Create FTP account'), 'url' => ['create-ftponly']],
                ]
            ]); ?>
            <?= $box->renderSearchButton() ?>
            <?= $box->renderSorter([
                'attributes' => [
                    'login', 'client', 'seller', 'server', 'state', 'type'
                ],
            ]) ?>
            <?= $box->renderPerPage() ?>
        </div>
    <?php $box->endActions() ?>
    <?php $box->beginBulkActions() ?>
        <?= $box->renderDeleteButton() ?>
    <?php $box->endBulkActions() ?>
        <?= $box->renderSearchForm(['stateData' => $stateData, 'typeData' => $typeData]) ?>
    <?php $box->end() ?>

    <?php $box->beginBulkForm() ?>
        <?= AccountGridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'  => $model,
            'columns'      => [
                'checkbox',
                'account',
                'client',
                'seller',
                'server',
                'state',
                'type',
                'actions',
            ],
        ]) ?>
    <?php $box->endBulkForm() ?>
<?php Pjax::end();
