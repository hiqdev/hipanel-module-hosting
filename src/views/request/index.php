<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\RequestGridView;
use hipanel\widgets\ActionBox;
use hipanel\widgets\Pjax;

$this->title                    = Yii::t('app', 'Requests');
$this->params['breadcrumbs'][]  = $this->title;
$this->subtitle = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');

?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
<?php $box = ActionBox::begin(['model' => $model, 'dataProvider' => $dataProvider, 'bulk' => true]) ?>
<?php $box->beginActions() ?>

<?= $box->renderSearchButton() ?>
<?= $box->renderSorter([
    'attributes' => [
        'server',
        'time',
        'state',
    ],
]) ?>
<?= $box->renderPerPage() ?>
<?php $box->endActions() ?>
<?php $box->renderBulkActions([
    'items' => [
        $box->renderDeleteButton(Yii::t('app', 'Delete'))
    ],
]) ?>
<?= $box->renderSearchForm(compact('objectOptions', 'stateOptions', 'typeOptions')) ?>
<?php $box->end() ?>
<?php $box->beginBulkForm() ?>
<?= requestGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $model,
    'columns'      => [
        'checkbox',
        'classes',

        'server',
        'account',

        'object',
        'time',
        'state',

        'actions',
    ],
]) ?>
<?php $box->endBulkForm() ?>
<?php Pjax::end() ?>
