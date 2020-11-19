<?php

namespace hipanel\modules\hosting\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\RenderAction;
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\base\CrudController;
use hipanel\filters\EasyAccessControl;
use hipanel\modules\hosting\actions\TreeGridRowsAction;
use hipanel\modules\hosting\helpers\PrefixSort;
use hipanel\modules\hosting\models\Prefix;
use yii\base\Event;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use Yii;

class PrefixController extends CrudController
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => EasyAccessControl::class,
                'actions' => [
                    'create' => 'admin',
                    'update' => 'admin',
                    'delete' => 'admin',
                    '*' => 'ip.read',
                ],
            ],
        ]);
    }

    public function actions()
    {
        return array_merge(parent::actions(), [
            'index' => [
                'class' => IndexAction::class,
            ],
            'view' => [
                'class' => ViewAction::class,
                'on beforePerform' => function (Event $event) {
                    $event->sender->getDataProvider()->query->withParent();
                },
                'data' => static function ($action): array {
                    $children = Prefix::find()
                        ->andWhere(['ip_cnts' => $action->getCollection()->first->ip])
                        ->includeSuggestions()
                        ->withParent()
                        ->firstbornOnly()
                        ->limit(-1)
                        ->all();
                    PrefixSort::byCidr($children);
                    $childDataProvider = new ArrayDataProvider([
                        'allModels' => $children,
                    ]);
                    $parents = Prefix::find()
                        ->andWhere(['ip_cntd' => $action->getCollection()->first->ip])
                        ->withParent()
                        ->limit(-1)
                        ->all();
                    PrefixSort::byKinship($parents);
                    $parentDataProvider = new ArrayDataProvider([
                        'allModels' => $parents,
                    ]);

                    return [
                        'childPrefixesDataProvider' => $childDataProvider,
                        'parentPrefixesDataProvider' => $parentDataProvider,
                    ];
                },
            ],
            'create' => [
                'class' => SmartCreateAction::class,
                'success' => Yii::t('hipanel.hosting.ipam', 'Prefix was created successfully'),
                'error' => Yii::t('hipanel.hosting.ipam', 'An error occurred when trying to add a prefix'),
                'data' => static function (RenderAction $action): array {
                    $prefix = $action->getCollection()->getModel();
                    $prefix->ip = $action->controller->request->get('ip');

                    return [
                        'model' => $prefix,
                        'models' => [$prefix],
                    ];
                },
            ],
            'update' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel.hosting.ipam', 'Prefix was updated successfully'),
                'error' => Yii::t('hipanel.hosting.ipam', 'An error occurred when trying to update a prefix'),
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('hipanel.hosting.ipam', 'Prefix was deleted successfully'),
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
            'set-note' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel.hosting.ipam', 'Description was changed'),
                'error' => Yii::t('hipanel.hosting.ipam', 'Failed to change description'),
            ],
            'get-tree-grid-rows' => [
                'class' => TreeGridRowsAction::class,
                'columns' => ['ip', 'state', 'vrf', 'role', 'site', 'text_note'],
            ],
        ]);
    }
}
