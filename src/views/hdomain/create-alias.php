<?php

/* @var $this yii\web\View */
/* @var $type string */

$this->title = Yii::t('hipanel/hosting', 'Create alias');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel', 'Domains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="db-create">
    <?= $this->render('_form-alias', compact('model', 'models')) ?>
</div>
