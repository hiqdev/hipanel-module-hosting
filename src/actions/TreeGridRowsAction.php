<?php

namespace hipanel\modules\hosting\actions;

use hipanel\actions\Action;
use hipanel\modules\hosting\grid\PrefixGridView;
use hipanel\modules\hosting\helpers\PrefixSort;
use hipanel\modules\hosting\models\Prefix;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Response;

class TreeGridRowsAction extends Action
{
    public array $columns;

    public function run(): array
    {
        $this->controller->response->format = Response::FORMAT_JSON;
        $id = $this->controller->request->get('id');
        $includeSuggestions = $this->controller->request->get('includeSuggestions', false);
        $prefix = Prefix::findOne($id);
        $query = Prefix::find()
            ->andWhere(['ip_cnts' => $prefix->ip, 'vrf' => $prefix->vrf])
            ->withParent()
            ->firstbornOnly()
            ->limit(-1);
        if ($includeSuggestions) {
            $query->includeSuggestions();
        }
        $models = $query->all();
        PrefixSort::byCidr($models);
        $dp = new ArrayDataProvider(['allModels' => $models, 'pagination' => ['pageSize' => false]]);
        $grid = Yii::createObject([
            'class' => PrefixGridView::class,
            'dataProvider' => $dp,
            'columns' => $this->columns,
            'layout' => '{items}{pager}',
            'filterModel' => new Prefix(),
            'rowOptions' => static fn(Prefix $prefix, $key): array => [
                'data' => [
                    'tt-id' => $prefix->id,
                    'tt-parent-id' => $prefix->parent_id ?? $id,
                    'tt-branch' => $prefix->child_count > 0 ? 'true' : 'false',
                ],
                'class' => sprintf("%s", $prefix->isSuggested() ? 'success' : ''),
            ],
            'tableOptions' => ['class' => 'table table-striped table-bordered'],
            'filterRowOptions' => ['style' => 'display: none;'],
        ]);
        $keys = $dp->getKeys();
        $rows = [];
        foreach ($dp->getModels() as $index => $model) {
            $key = $keys[$index];
            $rows[$key] = $grid->renderTableRow($model, $key, $index);
        }

        return $rows;
    }
}
