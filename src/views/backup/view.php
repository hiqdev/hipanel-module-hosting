<?php

use hipanel\modules\hosting\grid\BackupGridView;
use yii\helpers\Html;

$this->title = Html::encode('ID: ' . $model->object_id);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Backups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-md-12">
        <?= BackupGridView::detailView([
            'model' => $model,
            'columns' => [
                'id',
                'object_id',
                'client',
                'account',
                'server',
                'object',
                'time',
                'size'
            ],
        ]) ?>
    </div>
</div>
