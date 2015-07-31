<?php
/* @var $this yii\web\View */
/* @var $model hipanel\modules\ticket\models\Thread */
/* @var $type string */

$this->title                   = Yii::t('app', 'Create domain');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Domains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="db-create">
    <?= $this->render('_form', compact('model')) ?>
</div>
