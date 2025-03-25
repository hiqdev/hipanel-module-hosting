<?php

/**
 * @var AdvancedSearch $search
 * @var array $stateOptions
 */

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\widgets\combo\AccountCombo;
use hipanel\modules\server\widgets\combo\ServerCombo;
use hipanel\widgets\AdvancedSearch;
use hipanel\widgets\MonthPicker;
use hiqdev\combo\StaticCombo;

if (empty($search->model->period)) {
    $search->model->period = Yii::$app->formatter->asDatetime(new DateTime(), 'php:Y-m');
}

?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('state')->widget(StaticCombo::class, [
        'data' => $stateOptions,
        'hasId' => true,
        'multiple' => false,
    ]) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('account')->widget(AccountCombo::class) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('server')->widget(ServerCombo::class, ['formElementSelector' => '.form-group']) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('object')->dropDownList([
        'hdomain' => Yii::t('hipanel:hosting', 'Domain'),
        'db' => Yii::t('hipanel:hosting', 'DB'),
        'service' => Yii::t('hipanel:hosting', 'Service'),
    ], ['prompt' => '--']) ?>
</div>

<?php if (Yii::$app->user->can('support')) : ?>
  <div class="col-md-4 col-sm-6 col-xs-12">
      <?= $search->field('client_id')->widget(ClientCombo::class, ['formElementSelector' => '.form-group']) ?>
  </div>
<?php endif ?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('period')->widget(MonthPicker::class, [
        'clientOptions' => [
            'dateFormat' => 'Y-m',
            'maxDate' => (new DateTime())->modify("last day of this month")->format('Y-m'),
        ],
    ]) ?>
</div>
