<?php

use hipanel\modules\hosting\grid\BackupGridView;
use hipanel\modules\hosting\grid\BackupingGridView;
use hipanel\modules\hosting\models\Backup;
use yii\helpers\Html;
use yii\helpers\Inflector;

$this->title = 'ID: ' . Html::encode($model->id);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Backups'), 'url' => ['index']];
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
                        <?= $this->title ?>
                    </span>
                    <br>
                    <span class="profile-user-name">
                        <?= $model->client; ?>
                    </span>
                </p>

                <?= BackupingGridView::detailView([
                    'model' => $model,
                    'boxed' => false,
                    'gridOptions' => [
                        'typeOptions' => $typeOptions,
                    ],
                    'columns' => [
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
                    ],
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <?= Html::beginForm('/hosting/backup/index', 'POST') ?>
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('hipanel', 'Backups')?></h3>
                <div class="box-tools pull-right">
                    <?= Html::submitButton(Yii::t('hipanel', 'Delete'), ['class' => 'btn btn-sm btn-danger'])?>
                </div>
            </div>
            <div class="box-body no-padding">
                <?= BackupGridView::widget([
                    'boxed' => false,
                    'dataProvider' => $backupsDataProvider,
                    'filterModel' => $model,
                    'tableOptions' => [
                        'class' => 'table table-striped'
                    ],
                    'filterRowOptions' => ['style' => 'display: none;'],
                    'columns' => [
                        'checkbox',
                        'time',
                        'size',
                        'inner_actions'
                    ],
                ]) ?>
            </div>
        </div>
        <?= Html::endForm() ?>
    </div>
</div>
