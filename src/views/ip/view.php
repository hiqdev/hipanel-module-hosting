<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\IpGridView;
use hipanel\modules\hosting\models\Ip;
use hipanel\widgets\Box;
use hipanel\widgets\ModalButton;
use hipanel\widgets\Pjax;
use yii\helpers\Html;

/**
 * @var $model Ip
 */
$this->title = $model->ip;
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel/hosting', 'IP addresses'), 'url' => ['index']];
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
            <i class="fa fa-globe fa-5x"></i>
        </div>
        <p class="text-center">
            <span class="profile-user-role"><?= $model->ip ?></span>
        </p>

        <div class="profile-usermenu">
            <ul class="nav">
                <li><?= Html::a('<i class="fa fa-pencil"></i>' . Yii::t('hipanel', 'Update'), ['update', 'id' => $model->id]) ?></li>
                <li>
                    <?= ModalButton::widget([
                        'model' => $model,
                        'scenario' => 'delete',
                        'button' => [
                            'label' => '<i class="fa fa-trash-o"></i>' . Yii::t('hipanel', 'Delete'),
                        ],
                        'modal' => [
                            'header' => Html::tag('h4', Yii::t('hipanel/hosting', 'Confirm IP address deleting')),
                            'headerOptions' => ['class' => 'label-info'],
                            'footer' => [
                                'label' => Yii::t('hipanel/hosting', 'Delete IP address'),
                                'data-loading-text' => Yii::t('hipanel/hosting', 'Deleting IP address...'),
                                'class' => 'btn btn-danger',
                            ]
                        ],
                        'body' => Yii::t('app',
                            'Are you sure, that you want to delete IP address {ip}? All related objects might be deleted too!',
                            ['ip' => $model->ip]
                        )
                    ]) ?>
                </li>
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
                        echo $box->renderTitle(Yii::t('app', 'Mailbox information'));
                    $box->endHeader();
                    $box->beginBody();
                        echo IpGridView::detailView([
                            'boxed' => false,
                            'model' => $model,
                            'columns' => [
                                'ip',
                                'tags',
                                'counters',
                                'links',
                                'ptr',
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
