<?php

use hipanel\modules\hosting\grid\RequestGridView;
use hipanel\widgets\Box;
use yii\helpers\Html;

$this->title = Html::encode(Yii::t('hipanel', 'Request') . ' #' . $model->id);
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel', 'Requests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">

    <div class="col-md-4">
        <?= RequestGridView::detailView([
            'model' => $model,
            'boxOptions' => ['bodyOptions' => ['class' => 'no-padding']],
            'columns' => [
                'classes',
                'server',
                'account',
                'object',
                'parent',
                'pid',
                'time:datetime',
                'create_time:datetime',
                'update_time:datetime',
                'state',
            ],
        ]) ?>
    </div>

    <?php if (Yii::$app->user->can('admin') && $model->error_detailed) : ?>
        <div class="col-md-8">
            <?php Box::begin(['bodyOptions' => ['class' => 'no-padding']]); ?>
            <?= Html::tag('pre', $model->error_detailed) ?>
            <?php Box::end(); ?>
        </div>
    <?php endif; ?>

</div>

