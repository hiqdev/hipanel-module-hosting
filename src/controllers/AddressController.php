<?php

namespace hipanel\modules\hosting\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\SearchAction;
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\base\CrudController;
use hipanel\filters\EasyAccessControl;
use hipanel\modules\hosting\helpers\PrefixSort;
use hipanel\modules\hosting\models\Prefix;
use yii\base\Event;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use Yii;

class AddressController extends CrudController
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
                'findOptions' => ['with_parent' => 1],
                'data' => static function ($action) {
                    $parents = Prefix::find()->andWhere(['ip_cntd' => $action->getCollection()->first->ip])->withParent()->all();
                    PrefixSort::byKinship($parents);
                    $parentDataProvider = new ArrayDataProvider([
                        'allModels' => $parents,
                    ]);

                    return ['parentPrefixesDataProvider' => $parentDataProvider];
                },
            ],
            'create' => [
                'class' => SmartCreateAction::class,
                'success' => Yii::t('hipanel.hosting.ipam', 'IP Address was created successfully'),
                'error' => Yii::t('hipanel.hosting.ipam', 'An error occurred when trying to add a prefix'),
            ],
            'update' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel.hosting.ipam', 'IP Address was updated successfully'),
                'error' => Yii::t('hipanel.hosting.ipam', 'An error occurred when trying to update a prefix'),
                'on beforeFetch' => static function (Event $event): void {
                    /** @var SearchAction $action */
                    $action = $event->sender;
                    $dataProvider = $action->getDataProvider();
                    $dataProvider->query->withParent();
                },
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('hipanel.hosting.ipam', 'IP Address was deleted successfully'),
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
            'set-note' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel.hosting.ipam', 'Description was changed'),
                'error' => Yii::t('hipanel.hosting.ipam', 'Failed to change description'),
            ],
        ]);
    }
}
