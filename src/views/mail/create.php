<?php
/* @var $this yii\web\View */
/* @var $model hipanel\modules\hosting\models\Mail */
/* @var $type string */

$this->title                   = Yii::t('app', 'Create mailbox');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mailboxes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="mailbox-create">
    <?= $this->render('_form', compact('models')) ?>
</div>
