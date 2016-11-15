<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\ServiceGridView;
use hipanel\widgets\Box;
use hipanel\widgets\ModalButton;
use hipanel\widgets\Pjax;
use yii\helpers\Html;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:hosting', 'Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php Pjax::begin(Yii::$app->params['pjax']) ?>

<div class="row">
    <div class="col-md-3">
        <?php Box::begin([
            'options' => [
                'class' => 'box-solid',
            ],
            'bodyOptions' => [
                'class' => 'no-padding'
            ]
        ]); ?>
        <div class="profile-user-img text-center">
            <i class="fa fa-cogs fa-5x"></i>
        </div>
        <p class="text-center">
            <span class="profile-user-role"><?= $model->name ?></span>
        </p>

        <div class="profile-usermenu">
            <ul class="nav">
                <?php if (Yii::$app->user->can('admin')) : ?>
                    <li><?= Html::a('<i class="fa fa-pencil"></i>' . Yii::t('hipanel', 'Update'), ['update', 'id' => $model->id]) ?></li>
                <?php endif; ?>
            </ul>
        </div>
        <?php Box::end(); ?>
    </div>

    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <?php
                $box = Box::begin(['renderBody' => false]);
                    $box->beginHeader();
                        echo $box->renderTitle(Yii::t('hipanel:hosting', 'Service information'));
                    $box->endHeader();
                    $box->beginBody();
                        echo ServiceGridView::detailView([
                            'model' => $model,
                            'boxed' => false,
                            'columns' => [
                                'seller_id',
                                'client_id',
                                'server',
                                'service',
                                'ip',
                                'bin',
                                'etc',
                                'soft',
                                'state',
                            ],
                        ]);
                    $box->endBody();
                $box->end();
                ?>
            </div>
        </div>
    </div>
</div>

<?php Pjax::end() ?>
