<?php

use hipanel\modules\server\widgets\combo\ServerCombo;
use hiqdev\combo\StaticCombo;
use yii\web\View;

/**
 * @var \hipanel\widgets\AdvancedSearch $search
 * @var $this View
 * @var $ipTags array
 */

?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('ip_like')->label(Yii::t('hipanel/hosting', 'IP')) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('server_in')->widget(ServerCombo::class, ['formElementSelector' => '.form-group']) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('tag_in')->widget(StaticCombo::class, [
        'data' => array_merge(['' => Yii::t('hipanel', '---')], $ipTags),
        'hasId' => true,
        'multiple' => true,
    ]) ?>
</div>
