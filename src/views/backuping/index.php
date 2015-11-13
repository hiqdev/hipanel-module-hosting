<?php

use hipanel\modules\hosting\grid\BackupingGridView;
use hipanel\widgets\ActionBox;
use hipanel\widgets\Pjax;

$this->title = Yii::t('app', 'Backup settings');
$this->params['breadcrumbs'][] = $this->title;
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('app', 'filtered list') : Yii::t('app', 'full list');

?>
<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
<?php $box = ActionBox::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>
<?php $box->beginActions() ?>

<?= $box->renderSearchButton() ?>
<?= $box->renderSorter([
    'attributes' => [
        'client',
        'account',
        'server',
        'object',
        'name',

//        'backupcount',
//        'type',
//        'backuplast',
//        'disk',
    ],
]) ?>
<?= $box->renderPerPage() ?>
<?php $box->endActions() ?>
<?php $box->renderBulkActions([
    'items' => [
        $box->renderBulkButton(Yii::t('app', 'Enable'), 'enable'),
        $box->renderBulkButton(Yii::t('app', 'Disable'), 'disable'),
        $box->renderDeleteButton(Yii::t('app', 'Delete')),
    ],
]) ?>
<?= $box->renderSearchForm(compact('stateOptions')) ?>
<?php $box->end() ?>
<?php $box->beginBulkForm() ?>

<?= BackupingGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
    'typeOptions' => $typeOptions,
    'columns' => [
        'checkbox',
        'name',
        'client',
        'account',
        'server',
        'object',
        'backup_count',
        'type',
        'state_label',
        'backup_last',
        'total_du_gb',
        'actions',
    ],
]) ?>
<?php $box->endBulkForm() ?>
<?php Pjax::end() ?>