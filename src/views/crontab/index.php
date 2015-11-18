<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\CrontabGridView;
use hipanel\widgets\ActionBox;
use hipanel\widgets\Pjax;

$this->title = Yii::t('app', 'Crons');
$this->params['breadcrumbs'][] = $this->title;
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? 'filtered list' : 'full list';

?>
<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
<?php $box = ActionBox::begin(['model' => $model, 'dataProvider' => $dataProvider, 'bulk' => false]) ?>
<?php $box->beginActions() ?>

<?= $box->renderSearchButton() ?>
<?= $box->renderSorter([
    'attributes' => [
        'account',
        'client',
        'server',
    ],
]) ?>
<?= $box->renderPerPage() ?>
<?php $box->endActions() ?>

<?= $box->renderSearchForm(compact('objectOptions')) ?>
<?php $box->end() ?>
<?php $box->beginBulkForm() ?>
<?= CrontabGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
//        'checkbox',
        'crontab',
        'account',
        'server',
        'client',
        'state',
        'actions',
    ],
]) ?>
<?php $box->endBulkForm() ?>
<?php Pjax::end() ?>