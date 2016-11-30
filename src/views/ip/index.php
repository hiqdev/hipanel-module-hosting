<?php

use hipanel\modules\hosting\grid\IpGridView;
use hipanel\widgets\AjaxModal;
use hipanel\widgets\IndexPage;
use hipanel\widgets\Pjax;
use yii\helpers\Html;
use yii\web\JsExpression;

$this->title = Yii::t('hipanel:hosting', 'IP addresses');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
    <?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>

        <?php $page->setSearchFormData(compact(['ipTags'])) ?>

        <?php $page->beginContent('main-actions') ?>
            <?php if (Yii::$app->user->can('support')) : ?>
                <?= Html::a(Yii::t('hipanel:hosting', 'Create IP'), 'create', ['class' => 'btn btn-sm btn-success']) ?>
            <?php endif; ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('show-actions') ?>
            <?= $page->renderLayoutSwitcher() ?>
            <?= $page->renderSorter([
                'attributes' => [
                    'ip'
                ],
            ]) ?>
            <?= $page->renderPerPage() ?>
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
                        'actions',
                        'tags',
                        'counters',
                        'links',
                    ],
                ]) ?>
            <?php $page->endBulkForm() ?>
            <?= AjaxModal::widget([
                'id' => 'expand-ip',
                'header'=> Html::tag('h4', Yii::t('hipanel:hosting', 'Expanded range'), ['class' => 'modal-title']),
                'scenario' => 'expand',
                'actionUrl' => ['expand'],
                'size' => AjaxModal::SIZE_LARGE,
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

