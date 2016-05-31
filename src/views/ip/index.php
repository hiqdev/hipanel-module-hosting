<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\IpGridView;
use hipanel\widgets\ActionBox;
use hipanel\widgets\AjaxModal;
use hipanel\widgets\IndexLayoutSwitcher;
use hipanel\widgets\IndexPage;
use hipanel\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\web\JsExpression;

$this->title = Yii::t('hipanel/hosting', 'IP addresses');
$this->params['breadcrumbs'][] = $this->title;
$this->subtitle = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
    <?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>

        <?= $page->setSearchFormData(compact(['ipTags'])) ?>

        <?php $page->beginContent('main-actions') ?>
            <?= Html::a(Yii::t('hipanel/hosting', 'Create IP'), 'create', ['class' => 'btn btn-sm btn-success']) ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('show-actions') ?>
        <?= IndexLayoutSwitcher::widget() ?>
        <?= $page->renderSorter([
            'attributes' => [
                'ip'
            ],
        ]) ?>
        <?= $page->renderPerPage() ?>
        <?= $page->renderRepresentation() ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('bulk-actions') ?>
            <?= $page->renderBulkButton(Yii::t('hipanel', 'Delete'), 'delete', 'danger')?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('table') ?>
        <?php $page->beginBulkForm() ?>
            <?php echo IpGridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'  => $model,
                'boxed' => false,
                'ipTags' => $ipTags,
                'columns' => [
                    'ip',
                    'tags',
                    'counters',
                    'links',
                    'actions',
                ],
            ]) ?>
        <?php $page->endBulkForm() ?>
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
        <?php $page->endContent() ?>
    <?php $page->end() ?>
<?php Pjax::end() ?>

