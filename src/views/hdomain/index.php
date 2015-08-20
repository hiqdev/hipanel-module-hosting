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

Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])); ?>

<?php $box = ActionBox::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>
    <?php $box->beginActions() ?>
        <?= $box->renderCreateButton(Yii::t('app', 'Create domain')) ?>
        <?= $box->renderSearchButton() ?>
        <?= $box->renderSorter([
            'attributes' => [
                'domain',
                'client',
                'seller',
                'account',
                'server',
                'state',
            ],
        ]) ?>
        <?= $box->renderPerPage() ?>
    <?php $box->endActions() ?>

    <?php $box->beginBulkActions() ?>
        <?= $box->renderDeleteButton() ?>
    <?php $box->endBulkActions() ?>
        <?= $box->renderSearchForm(compact(['stateData', 'typeData'])) ?>
    <?php $box->end() ?>
    <?php $box->beginBulkForm() ?>
        <?= HdomainGridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'  => $model,
            'columns'      => [
                'checkbox',
                'hdomain',
                'client',
                'seller',
                'account',
                'server',
                'state',
                'ip',
                'service',
                'actions',
            ],
        ]) ?>
    <?php $box->endBulkForm() ?>
<?php Pjax::end();
