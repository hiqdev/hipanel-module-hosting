<?php

/** @var $this yii\web\View */
/** @var $type string */

$this->title = Yii::t('hipanel/hosting', 'Create domain');
$this->breadcrumbs->setItems([['label' => Yii::t('hipanel', 'Domains'), 'url' => ['index']]]);
$this->breadcrumbs->setItems([$this->title]);
?>

<div class="db-create">
    <?= $this->render('_form', compact('model', 'models')) ?>
</div>
