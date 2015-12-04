<?php

use hipanel\modules\server\widgets\combo\ServerCombo;
use hiqdev\combo\StaticCombo;
use yii\web\View;

/**
 * @var $this View
 */

?>

<div class="col-md-6">
    <?= $search->field('ip_like')->label(Yii::t('hipanel/hosting', 'IP')) ?>
    <?= $search->field('server_in')->widget(ServerCombo::className(), ['formElementSelector' => '.form-group']) ?>
</div>

<div class="col-md-6">
    <?= $search->field('tag_in')->widget(StaticCombo::classname(), [
        'data' => array_merge(['' => Yii::t('app', '---')], $ipTags),
        'hasId' => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => true,
            ]
        ],
    ]) ?>
</div>


