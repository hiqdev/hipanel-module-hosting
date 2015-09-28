<?php
/* @var $this yii\web\View */
/* @var $type string */

$this->title = Yii::t('app', 'Create domain');
$this->breadcrumbs->setItems([['label' => Yii::t('app', 'Domains'), 'url' => ['index']]]);
$this->breadcrumbs->setItems([$this->title]);
?>

<div class="db-create">
    <?= $this->render('_form', compact('model', 'models')) ?>
</div>
