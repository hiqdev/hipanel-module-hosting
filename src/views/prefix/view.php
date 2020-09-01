<?php

use hipanel\modules\hosting\grid\PrefixGridView;
use hipanel\modules\hosting\menus\AggregateDetailMenu;
use hipanel\modules\hosting\menus\PrefixDetailMenu;
use hipanel\modules\hosting\models\Aggregate;
use hipanel\modules\hosting\models\Prefix;
use hipanel\widgets\IndexPage;
use hipanel\widgets\MainDetails;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Aggregate $model
 * @var ActiveDataProvider[] $childPrefixesDataProvider
 */

$this->title = Html::encode($model->ip);
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel.hosting.ipam', 'Prefixes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-md-3">
        <?= MainDetails::widget([
            'title' => $this->title,
            'subTitle' => Yii::t('hipanel.hosting.ipam', 'Prefix'),
            'menu' => PrefixDetailMenu::widget(['model' => $model], [
                'linkTemplate' => '<a href="{url}" {linkOptions}><span class="pull-right">{icon}</span>&nbsp;{label}</a>',
            ]),
        ]) ?>
        <div class="box box-widget">
            <div class="box-body no-padding">
                <?= PrefixGridView::detailView([
                    'boxed' => false,
                    'model' => $model,
                    'columns' => [
                        'family',
                        'type',
                        'vrf',
                        'role',
                        'site',
                        'utilization',
                        'note',
                    ],
                ]) ?>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <?php $page = IndexPage::begin(['model' => $model, 'layout' => 'noSearch']) ?>

            <?php $page->beginContent('show-actions') ?>
                <h4 class="box-title" style="display: inline-block;"><?= Yii::t('hipanel.hosting.ipam', 'Child prefixes') ?></h4>
            <?php $page->endContent() ?>

            <?php $page->beginContent('bulk-actions') ?>
                <?= $page->renderBulkDeleteButton('@prefix/delete') ?>
            <?php $page->endContent() ?>


            <?php $page->beginContent('table') ?>
                <?php $page->beginBulkForm() ?>
                    <?= PrefixGridView::widget([
                        'boxed' => false,
                        'dataProvider' => $childPrefixesDataProvider,
                        'filterModel' => new Prefix(),
                        'tableOptions' => [
                            'class' => 'table table-striped table-bordered',
                        ],
                        'filterRowOptions' => ['style' => 'display: none;'],
                        'columns' => [
                            'checkbox',
                            'actions',
                            'ip',
                            'state',
                            'vrf',
                            'role',
                            'site',
                            'note'
                        ],
                    ]) ?>
                <?php $page->endBulkForm() ?>
            <?php $page->endContent() ?>

        <?php $page::end() ?>
    </div>
</div>
