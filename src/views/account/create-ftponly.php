<?php
/* @var $this yii\web\View */
/* @var $model hipanel\modules\hosting\models\Account */
/* @var $type string */

$this->title                   = Yii::t('app', 'Create FTP account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="account-create">
    <?= $this->render('_form', compact('models')) ?>
</div>
