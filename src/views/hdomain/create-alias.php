<?php

/* @var $this yii\web\View */
/* @var $type string */

$this->title = Yii::t('app', 'Create alias');
$this->breadcrumbs->setItems([['label' => Yii::t('app', 'Domains'), 'url' => ['index']]]);
$this->breadcrumbs->setItems([$this->title]);
?>

<div class="db-create">
    <?= $this->render('_form-alias', compact('model', 'models')) ?>
</div>
