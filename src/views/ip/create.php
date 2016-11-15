<?php

/* @var $this yii\web\View */
/* @var $model hipanel\modules\hosting\models\Ip */
/* @var $tags array */

$this->title = Yii::t('hipanel:hosting', 'Create IP');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:hosting', 'IP addresses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="ip-create">
    <?= $this->render('_form', compact('models', 'model', 'tags', 'links')) ?>
</div>
