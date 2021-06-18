<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

/**
 * @see    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\hosting\controllers;

use hipanel\actions\ComboSearchAction;
use hipanel\actions\IndexAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\ViewAction;
use hipanel\filters\EasyAccessControl;
use Yii;

class RequestController extends \hipanel\base\CrudController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => EasyAccessControl::class,
                'actions' => [
                    '*' => Yii::$app->params['module.hosting.is_public'] || Yii::$app->user->can('support')
                        ? 'request.read'
                        : false,
                ],
            ],
        ]);
    }

    public function actions()
    {
        return array_merge(parent::actions(), [
            'search' => [
                'class' => ComboSearchAction::class,
            ],
            'index' => [
                'class' => IndexAction::class,
                'findOptions' => [
                    'object_class_ni' => 'domain',
                ],
                'data' => function ($action) {
                    return [
                        'objects' => $this->getObjects(),
                        'states' => $this->getFilteredStates(),
                    ];
                },
                'filterStorageMap' => [
                    'state' => 'hosting.request.state',
                    'server' => 'server.server.name',
                    'account' => 'hosting.account.login',
                    'client_id' => 'client.client.id',
                ],
            ],
            'view' => [
                'class' => ViewAction::class,
                'findOptions' => [
                    'object_class_ni' => 'domain',
                ],
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('hipanel:hosting', 'Deleted'),
                'error' => Yii::t('hipanel:hosting', 'An error occurred when trying to delete request.'),
            ],
        ]);
    }

    public function getFilteredStates()
    {
        $result = $this->getStates();
        unset($result['done']);

        return $result;
    }

    public function getStates()
    {
        return $this->getRefs('state,request', 'hipanel:hosting');
    }

    public function getObjects()
    {
        return [
            'db'        => Yii::t('hipanel:hosting', 'Database'),
            'hdomain'   => Yii::t('hipanel:hosting', 'Domain'),
            'device'    => Yii::t('hipanel:hosting', 'Server'),
            'service'   => Yii::t('hipanel:hosting', 'Service'),
        ];
    }
}
