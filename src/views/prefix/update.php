<?php

/* @var $this yii\web\View */
/* @var $model hipanel\modules\hosting\models\Aggregate */
/* @var $tags array */

$this->title = Yii::t('hipanel:hosting', 'Update Prefix');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel.hosting.ipam', 'Prefixes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ip, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $model->ip;

?>

<?= $this->render('_form', compact('models', 'model')) ?>
