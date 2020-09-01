<?php

/* @var $this yii\web\View */
/* @var $model hipanel\modules\hosting\models\Aggregate */
/* @var $tags array */

$this->title = Yii::t('hipanel.hosting.ipam', 'Add new address');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel.hosting.ipam', 'IP Addresses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_form', compact('models', 'model')) ?>
