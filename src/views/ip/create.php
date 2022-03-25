<?php

use hipanel\modules\hosting\models\Ip;

/**
 * @var array $tags
 * @var Ip $model
 * @var array $models
 * @var yii\web\View $this
 */

$this->title = Yii::t('hipanel:hosting', 'Create IP');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:hosting', 'IP addresses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="ip-create">
    <?= $this->render('_form', compact('models', 'model', 'tags')) ?>
</div>
