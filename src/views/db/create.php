<?php

/* @var $this yii\web\View */
/* @var $model hipanel\modules\ticket\models\Thread */
/* @var $type string */

$this->title = Yii::t('hipanel/hosting', 'Create database');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel', 'Databases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="db-create">
    <?= $this->render('_form', compact('models', 'model')) ?>
</div>
