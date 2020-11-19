<?php

namespace hipanel\modules\hosting\actions;

use hipanel\actions\Action;
use hipanel\modules\hosting\grid\PrefixGridView;
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
        $models = Prefix::find()->where(['parent_id' => $id])->withparent()->limit(-1)->all();
        $dp = new ArrayDataProvider(['allModels' => $models]);
        $grid = Yii::createObject([
            'class' => PrefixGridView::class,
            'dataProvider' => $dp,
            'columns' => $this->columns,
            'layout' => '{items}{pager}',
            'filterModel' => new Prefix(),
            'rowOptions' => static fn(Prefix $prefix, $key): array => [
                'data' => [
                    'tt-id' => $prefix->id,
                    'tt-parent-id' => $prefix->parent_id ?? 0,
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
            $rows[$model->id] = $grid->renderTableRow($model, $key, $index);
        }

        return $rows;
    }
}
