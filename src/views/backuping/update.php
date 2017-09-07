<?php

/* @var $this yii\web\View */
/* @var $model hipanel\modules\hosting\models\Backuping */
/* @var $tags array */

$this->title = Yii::t('hipanel:hosting', 'Update settings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:hosting', 'Backups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_form', compact('models', 'model', 'typeOptions', 'methodOptions', 'dayOptions', 'hourOptions')) ?>
