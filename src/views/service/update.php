<?php

/* @var $this yii\web\View */
/* @var $model hipanel\modules\hosting\models\Service */
/* @var $softs array */
/* @var $states array */

$this->title = Yii::t('hipanel:hosting', 'Update service');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:hosting', 'Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="service-update">
    <?= $this->render('_form', compact('models', 'model', 'softs', 'states')) ?>
</div>
