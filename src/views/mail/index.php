<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\MailGridView;
use hipanel\widgets\ActionBox;
use hipanel\widgets\Pjax;

$this->title = Yii::t('app', 'Mailboxes');
$this->breadcrumbs->setItems([
    $this->title,
]);
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? 'filtered list' : 'full list'; ?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])); ?>

<?php $box = ActionBox::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>
<?php $box->beginActions() ?>
    <?= $box->renderCreateButton(Yii::t('app', 'Create mailbox')) . '&nbsp;' ?>
    <?= $box->renderSearchButton() ?>
    <?= $box->renderSorter([
        'attributes' => [
            'client',
            'seller',
            'account',
            'state',
            'server',
            'mail',
        ],
    ]) ?>
    <?= $box->renderPerPage() ?>
<?php $box->endActions() ?>
<?php $box->beginBulkActions() ?>

<?= $box->renderDeleteButton() ?>
<?php $box->endBulkActions() ?>
<?= $box->renderSearchForm(['stateData' => $stateData, 'typeData' => $typeData]) ?>
<?php $box->end() ?>

<?php $box->beginBulkForm() ?>
<?= MailGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
    'columns' => [
        'checkbox',
        'mail',
        'type',
        'forwards',
        'client',
        'seller',
        'server',
        'state',
        'actions',
    ],
]) ?>
<?php $box->endBulkForm() ?>
<?php Pjax::end();
