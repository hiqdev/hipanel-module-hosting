<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\HdomainGridView;
use hipanel\widgets\ActionBox;
use hipanel\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Domains');
$this->breadcrumbs->setItems([
    $this->title,
]);
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? 'filtered list' : 'full list';

Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])); ?>

<?php $box = ActionBox::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>
    <?php $box->beginActions() ?>
            <div class="dropdown">
                <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <?= Yii::t('app', 'Create domain'); ?>
                    <span class="caret"></span>
                </button>
                <?= \yii\bootstrap\Dropdown::widget([
                    'items' => [
                        ['label' => Yii::t('app', 'Create domain'), 'url' => ['create']],
                        ['label' => Yii::t('app', 'Create alias for domain'), 'url' => ['create-alias']],
                    ]
                ]); ?>
                <?= $box->renderSearchButton() ?>
                <?= $box->renderSorter([
                    'attributes' => [
                        'domain',
                        'client',
                        'seller',
                        'account',
                        'server',
                        'state',
                    ],
                ]) ?>
                <?= $box->renderPerPage() ?>
            </div>
        <?php $box->endActions() ?>
    <?php $box->beginBulkActions() ?>
        <?= $box->renderDeleteButton() ?>
    <?php $box->endBulkActions() ?>
        <?= $box->renderSearchForm(compact(['stateData', 'typeData'])) ?>
    <?php $box->end() ?>
    <?php $box->beginBulkForm() ?>
        <?= HdomainGridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'  => $model,
            'columns'      => [
                'checkbox',
                'hdomain_with_aliases',
                'client',
                'seller',
                'account',
                'server',
                'state',
                'ip',
                'service',
                'actions',
            ],
        ]) ?>
    <?php $box->endBulkForm() ?>
<?php Pjax::end();
