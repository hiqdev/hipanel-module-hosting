<?php

use hipanel\modules\hosting\grid\BackupingGridView;
use hipanel\widgets\ActionBox;
use hipanel\widgets\Pjax;

$this->title = Yii::t('hipanel/hosting', 'Backup settings');
$this->params['breadcrumbs'][] = $this->title;
$this->subtitle = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');

?>
<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
<?php $box = ActionBox::begin(['model' => $model, 'dataProvider' => $dataProvider, 'bulk' => true]) ?>
<?php $box->beginActions() ?>

<?= $box->renderSearchButton() ?>
<?= $box->renderSorter([
    'attributes' => [
        'client',
        'account',
        'server',
        'name',
    ],
]) ?>
<?= $box->renderPerPage() ?>
<?php $box->endActions() ?>
<?php $box->renderBulkActions([
    'items' => [
        $box->renderBulkButton(Yii::t('hipanel', 'Enable'), 'enable'),
        $box->renderBulkButton(Yii::t('hipanel', 'Disable'), 'disable'),
        $box->renderDeleteButton(Yii::t('hipanel', 'Delete')),
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
        'total_du',
        'actions',
    ],
]) ?>
<?php $box->endBulkForm() ?>
<?php Pjax::end() ?>
