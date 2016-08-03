<?php

/* @var $this yii\web\View */
/* @var $model hipanel\modules\hosting\models\Account */
/* @var $type string */

$this->title                   = Yii::t('hipanel/hosting', 'Create FTP account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel', 'Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="account-create">
    <?= $this->render('_form', compact('models')) ?>
</div>
