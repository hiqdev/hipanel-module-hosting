<?php
/* @var $this yii\web\View */
/* @var $model hipanel\modules\hosting\models\Mail */
/* @var $type string */

$this->title                   = Yii::t('app', 'Mailbox editing');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mailboxes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mail, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="mailbox-update">
    <?= $this->render('_form', compact('models')) ?>
</div>
