<?php

use hipanel\modules\hosting\grid\BackupingGridView;
use yii\helpers\Html;

$this->title = Html::encode($model->id);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Backup settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-md-4">
        <?php echo BackupingGridView::detailView([
            'model' => $model,
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
