<?php

use hipanel\modules\hosting\grid\RequestGridView;
use hipanel\widgets\Pjax;
use yii\helpers\Html;

$this->title = Html::encode(Yii::t('hipanel', 'Request') . ' #' . $model->id);
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel', 'Requests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">

    <div class="col-md-4">
        <?= RequestGridView::detailView([
            'model' => $model,
            'columns' => [
                'classes',
                'server',
                'account',
                'object',
                'time',
                'state',
            ],
        ]) ?>
    </div>

</div>

