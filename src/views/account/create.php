<?php
/* @var $this yii\web\View */
/* @var $model hipanel\modules\hosting\models\Account */
/* @var $type string */

$this->title                   = Yii::t('hipanel:hosting', 'Create account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:hosting', 'Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="account-create">
    <?= $this->render('_form', compact('models')) ?>
</div>
