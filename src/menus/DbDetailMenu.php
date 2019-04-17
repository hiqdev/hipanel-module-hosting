<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\menus;

use hipanel\widgets\ModalButton;
use Yii;
use yii\helpers\Html;

class DbDetailMenu extends \hipanel\menus\AbstractDetailMenu
{
    public $model;

    public function items()
    {
        return [
            [
                'label' => $this->render('_change-password', ['model' => $this->model]),
                'encode' => false,
            ],
            [
                'label' => ModalButton::widget([
                    'model' => $this->model,
                    'scenario' => 'truncate',
                    'button' => [
                        'label' => '<i class="fa fa-fw fa-file-o"></i>' . Yii::t('hipanel:hosting', 'Truncate'),
                    ],
                    'modal' => [
                        'header' => Html::tag('h4', Yii::t('hipanel:hosting', 'Confirm database truncating')),
                        'headerOptions' => ['class' => 'label-danger'],
                        'footer' => [
                            'label' => Yii::t('hipanel:hosting', 'Truncate database'),
                            'data-loading-text' => Yii::t('hipanel', 'Performing...'),
                            'class' => 'btn btn-danger',
                        ],
                    ],
                    'body' => Yii::t('hipanel:hosting',
                        'Are you sure that to truncate database {name}? All tables will be dropped, all data will be lost!',
                        ['name' => Html::tag('b', $this->model->name)]
                    ),
                ]),
                'encode' => false,
            ],
            [
                'label' => ModalButton::widget([
                    'model' => $this->model,
                    'scenario' => 'delete',
                    'button' => [
                        'label' => '<i class="fa fa-fw fa-trash-o"></i>' . Yii::t('hipanel', 'Delete'),
                    ],
                    'modal' => [
                        'header' => Html::tag('h4', Yii::t('hipanel:hosting', 'Confirm database deleting')),
                        'headerOptions' => ['class' => 'label-danger'],
                        'footer' => [
                            'label' => Yii::t('hipanel:hosting', 'Delete database'),
                            'data-loading-text' => Yii::t('hipanel', 'Deleting...'),
                            'class' => 'btn btn-danger',
                        ],
                    ],
                    'body' => Yii::t('hipanel:hosting', 'Are you sure to delete database {name}? All tables will be dropped, all data will be lost!',
                        ['name' => Html::tag('b', $this->model->name)]
                    ),
                ]),
                'encode' => false,
            ],
        ];
    }

    public function getViewPath()
    {
        return '@vendor/hiqdev/hipanel-module-hosting/src/views/db';
    }
}
