<?php

namespace hipanel\modules\hosting\widgets;

use hipanel\helpers\Url;
use hipanel\modules\hosting\assets\TreeTable;
use hipanel\modules\hosting\grid\PrefixGridView;
use hipanel\modules\hosting\models\Prefix;
use yii\base\Widget;
use yii\data\DataProviderInterface;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;

class TreeGrid extends Widget
{
    public DataProviderInterface $dataProvider;

    public array $columns;

    public bool $showAll = true;

    /**
     * @var array|string
     */
    public $url = 'get-tree-grid-rows';

    public function init(): void
    {
        TreeTable::register($this->view);
    }

    public function run(): string
    {
        $this->registerJs();
        $this->registerCss();

        return PrefixGridView::widget([
            'boxed' => false,
            'dataProvider' => $this->dataProvider,
            'layout' => '{items}{pager}',
            'filterModel' => new Prefix(),
            'rowOptions' => static fn(Prefix $prefix, $key): array => [
                'data' => [
                    'tt-id' => $prefix->id,
                    'tt-parent-id' => $prefix->parent_id ?? 0,
                    'tt-branch' => $prefix->child_count == 0 ? 'false' : 'true',
                ],
                'class' => sprintf("%s", $prefix->isSuggested() ? 'success' : ''),
            ],
            'tableOptions' => ['id' => $this->getId(), 'class' => 'table table-striped table-bordered'],
            'filterRowOptions' => ['style' => 'display: none;'],
            'columns' => $this->columns,
        ]);
    }

    private function registerJs(): void
    {
        $options = Json::encode(empty($this->pluginOptions) ? $this->getDefaultPluginOptions() : $this->pluginOptions);
        $id = $this->getId();
        $url = Url::toRoute($this->url);
        if ($this->showAll) {
            $this->view->registerJs("
              $('#{$id}').treetable({$options});
              $('#{$id}').treetable('expandAll');
            ", View::POS_LOAD);
        } else {
            $this->view->registerJs("
              const tte_{$id} = function() {
                const parentNodeId = this.id;
                const tt = $('#{$id}');
                if (this.children.length > 0) {
                  return;
                }
                $('.overlay').show();
                $.ajax({
                  url: '{$url}',
                  type: 'GET',
                  dataType: 'json',
                  data: { id: parentNodeId },
                  success: rows => {
                    $('.overlay').hide();
                    const parentNode = tt.treetable('node', parentNodeId);
                    if (Object.keys(rows).length) {
                      for (const [id, row] of Object.entries(rows)) {
                        if (!tt.treetable('node', id)) {
                          tt.treetable('loadBranch', parentNode, row);
                        }
                      }
                    }
                  },
                  error: error => {
                    console.log(error);
                    $('.overlay').hide();
                  }
                });
              }
              $('#{$id}').treetable({$options});
            ", View::POS_LOAD);
        }
    }

    private function getDefaultPluginOptions(): array
    {
        $options = [
            'expandable' => true,
            'indent' => 11,
            'expanderTemplate' => '<a href="#" class="fa fa-fw">&nbsp;</a>',
        ];
        if (!$this->showAll) {
            $options['onNodeExpand'] = new JsExpression("tte_{$this->getId()}");
//            $options['expandable'] = true;
        }

        return $options;
    }

    private function registerCss(): void
    {
        $this->view->registerCss(<<<'CSS'

table.treetable tr.collapsed span.indenter a:before {
    content: "\f0da";
}

table.treetable tr.expanded span.indenter a:before {
    content: "\f0d7";
}
.tab-content > .overlay, .box-body > .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 50;
    background: rgba(255,255,255,0.7);
    border-radius: 3px
}
.tab-content > .overlay > .fa, .box-body > .overlay > .fa {
    position: absolute;
    top: 50%;
    left: 50%;
    margin-left: -15px;
    margin-top: -15px;
    color: darkgrey;
    font-size: 30px
}
CSS
        );
    }
}
