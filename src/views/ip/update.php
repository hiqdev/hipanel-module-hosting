<?php

use hipanel\modules\hosting\models\Ip;

/**
 * @var array $tags
 * @var Ip $model
 * @var array $models
 * @var yii\web\View $this
 */

$this->title = Yii::t('hipanel:hosting', 'Update IP');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:hosting', 'IP addresses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ip, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="ip-update">
    <?= $this->render('_form', compact('models', 'model', 'tags')) ?>
</div>
