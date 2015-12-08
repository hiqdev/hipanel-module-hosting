<?php
/* @var $this yii\web\View */
/* @var $model hipanel\modules\hosting\models\Ip */
/* @var $tags array */

$this->title = Yii::t('hipanel/hosting', 'Update IP');
$this->breadcrumbs->setItems([
    ['label' => Yii::t('hipanel/hosting', 'IP addresses'), 'url' => ['index']],
    ['label' => $model->ip, 'url' => ['view', 'id' => $model->id]],
    ['label' => $this->title]
]);
?>

<div class="ip-update">
    <?= $this->render('_form', compact('models', 'model', 'tags', 'links')) ?>
</div>
