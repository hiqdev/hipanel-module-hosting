<?php

/* @var $this yii\web\View */
/* @var $model hipanel\modules\hosting\models\Ip */
/* @var $tags array */

$this->title = Yii::t('hipanel/hosting', 'Update IP');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel/hosting', 'IP addresses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ip, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="ip-update">
    <?= $this->render('_form', compact('models', 'model', 'tags', 'links')) ?>
</div>
