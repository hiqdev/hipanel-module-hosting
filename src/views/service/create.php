<?php
/* @var $this yii\web\View */
/* @var $model hipanel\modules\hosting\models\Service */
/* @var $softs array */
/* @var $states array */

$this->title                   = Yii::t('hipanel/hosting', 'Create service');
$this->breadcrumbs->setItems([['label' => Yii::t('hipanel/hosting', 'Services'), 'url' => ['index']]]);
$this->breadcrumbs->setItems([$this->title]);
?>

<div class="service-create">
    <?= $this->render('_form', compact('models', 'model', 'softs', 'states')) ?>
</div>
