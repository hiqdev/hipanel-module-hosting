<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\IpGridView;
use hipanel\widgets\ActionBox;
use hipanel\widgets\AjaxModal;
use hipanel\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\web\JsExpression;

$this->title = Yii::t('hipanel/hosting', 'IP addresses');
$this->params['breadcrumbs'][] = $this->title;
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? 'filtered list' : 'full list';
?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])); ?>
<?php $box = ActionBox::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>
    <?php $box->beginActions() ?>
        <?= $box->renderCreateButton(Yii::t('hipanel/hosting', 'Create IP')) ?>
        <?= $box->renderSearchButton() ?>
        <?= $box->renderSorter([
            'attributes' => [
                'ip'
            ],
        ]) ?>
        <?= $box->renderPerPage() ?>
    <?php $box->endActions() ?>
    <?php $box->beginBulkActions() ?>
        <?= $box->renderDeleteButton() ?>
    <?php $box->endBulkActions() ?>
    <?= $box->renderSearchForm(['ipTags' => $ipTags]) ?>
<?php $box->end(); ?>

<?php $box->beginBulkForm() ?>
    <?php echo IpGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $model,
        'ipTags' => $ipTags,
        'columns' => [
            'ip',
            'tags',
            'counters',
            'links',
            'actions',
        ],
    ]) ?>
<?php $box->endBulkForm() ?>
<?= AjaxModal::widget([
    'id' => 'expand-ip',
    'header'=> Html::tag('h4', Yii::t('hipanel/hosting', 'Expanded range'), ['class' => 'modal-title']),
    'scenario' => 'expand',
    'actionUrl' => ['expand'],
    'size' => Modal::SIZE_LARGE,
    'toggleButton' => false,
    'clientEvents' => [
        'show.bs.modal' => function ($widget) {
            return new JsExpression("function() {
                $.get('{$widget->actionUrl}', {'id': $('#{$widget->id}').data('ip_id')}).done(function (data) {
                    $('#{$widget->id} .modal-body').html(data);
                });;
            }");
        }
    ]
]) ?>
<?php $this->registerJs("$('.btn-expand-ip').click(function (event) {
    $('#expand-ip').data('ip_id', $(this).data('id')).modal('show');
    event.preventDefault();
});"); ?>
<?php Pjax::end();
