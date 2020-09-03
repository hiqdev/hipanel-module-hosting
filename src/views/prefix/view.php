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
 * @var ActiveDataProvider[] $parentPrefixesDataProvider
 * @var ActiveDataProvider[] $childPrefixesDataProvider
 */

$this->title = Html::encode($model->ip);
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel.hosting.ipam', 'Prefixes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$columns = ['actions', 'ip', 'state', 'vrf', 'role', 'site', 'note'];

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
                        'aggregate',
                        'role',
                        'site',
                        'utilization',
                        'ip_count',
                        'note',
                    ],
                ]) ?>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#parent_prefixes" data-toggle="tab" aria-expanded="true">Parent Prefixes</a>
                </li>
                <li class="">
                    <a href="#child_prefixes" data-toggle="tab" aria-expanded="false">Child Prefixes</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="parent_prefixes">
                    <?= PrefixGridView::widget([
                        'boxed' => false,
                        'dataProvider' => $parentPrefixesDataProvider,
                        'filterModel' => new Prefix(),
                        'tableOptions' => [
                            'class' => 'table table-striped table-bordered',
                        ],
                        'filterRowOptions' => ['style' => 'display: none;'],
                        'columns' => $columns,
                    ]) ?>
                </div>
                <div class="tab-pane" id="child_prefixes">
                    <?= PrefixGridView::widget([
                        'boxed' => false,
                        'dataProvider' => $childPrefixesDataProvider,
                        'filterModel' => new Prefix(),
                        'tableOptions' => [
                            'class' => 'table table-striped table-bordered',
                        ],
                        'filterRowOptions' => ['style' => 'display: none;'],
                        'columns' => $columns,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
