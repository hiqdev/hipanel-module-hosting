<?php

/* @var $this yii\web\View */
/* @var $model hipanel\modules\hosting\models\Mail */
/* @var $type string */

$this->title                   = Yii::t('hipanel/hosting', 'Create mailbox');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel/hosting', 'Mailboxes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="mailbox-create">
    <?= $this->render('_form', compact('models')) ?>
</div>
