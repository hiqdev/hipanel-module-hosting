<?php

use hipanel\helpers\Url;
use hipanel\modules\hosting\grid\BackupGridView;
use hipanel\modules\hosting\grid\BackupingGridView;
use hipanel\widgets\ClientSellerLink;
use hipanel\widgets\IndexPage;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/* @var $hasBackup bool */
$this->title = Yii::t('hipanel:hosting', 'Backup: {0} {1}', [$model->object === 'hdomain' ? Yii::t('hipanel:hosting', 'domain') : Yii::t('hipanel:hosting', 'database'), $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel', 'Backups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-md-3">
        <div class="box box-solid">
            <div class="box-body">
                <div class="profile-user-img text-center">
                    <i class="fa fa-archive fa-5x"></i>
                </div>
                <p class="text-center">
                    <span class="profile-user-role">
                        <?= $model->name ?>
                    </span>
                    <br>
                    <span class="profile-user-name"><?= ClientSellerLink::widget(compact('model')) ?></span>
                </p>

                <?= BackupingGridView::detailView([
                    'model' => $model,
                    'boxed' => false,
                    'gridOptions' => [
                        'typeOptions' => $typeOptions,
                    ],
                    'columns' => array_filter([
                        Yii::$app->user->can('support') ? 'id' : null,
                        'object', 'name',
                        Yii::$app->user->can('support') ? 'client' : null,
                        Yii::$app->user->can('support') ? 'seller' : null,
                        'account', 'server',
                        $model->type ? 'backup_count' : null,
                        $model->type ? 'type' : null,
                        $model->type ? 'state_label' : null,
                        $model->type ? 'backup_last' : null,
                        $model->type ? 'total_du' : null,
                    ]),
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <?php if ($hasBackup) : ?>
            <?php $page = IndexPage::begin(['model' => $model, 'layout' => 'noSearch']) ?>
            <?php $page->beginContent('show-actions') ?>
                <h4 class="box-title" style="display: inline-block;"><?= Yii::t('hipanel:hosting', 'Backups')?></h4>
            <?php $page->endContent() ?>
            <?php $page->beginContent('bulk-actions') ?>
                <?= $page->renderBulkButton(Yii::t('hipanel', 'Delete'), Url::toRoute('@backup/delete'), 'danger')?>
            <?php $page->endContent() ?>
            <?php $page->beginContent('table') ?>
            <?php $page->beginBulkForm() ?>
            <?= BackupGridView::widget([
                'boxed' => false,
                'dataProvider' => $backupsDataProvider,
                'filterModel' => $model,
                'tableOptions' => [
                    'class' => 'table table-striped table-bordered'
                ],
                'filterRowOptions' => ['style' => 'display: none;'],
                'columns' => [
                    'checkbox',
                    'time',
                    'size',
                    'inner_actions'
                ],
            ]) ?>
            <?php $page->endBulkForm() ?>
            <?php $page->endContent() ?>
            <?php $page->end() ?>

        <?php else: ?>
            <div class="box box-warning box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="icon fa fa-warning"></i>&nbsp;&nbsp;<?= Yii::t('hipanel:hosting', 'Backup is not enabled')?></h3>
                </div>
                <div class="box-body">
                    <?php $form = ActiveForm::begin(['action' => '@backuping/update']) ?>
                    <?= Html::activeHiddenInput($model, 'id') ?>
                    <?php $model->type = 'week' ?>
                    <?= $form->field($model, 'type')->dropDownList(BackupingGridView::$typeOptions) ?>
                    <?= Html::submitButton(Yii::t('hipanel:hosting', 'Enable backup'), ['class' => 'btn btn-success']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>
