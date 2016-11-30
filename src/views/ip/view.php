<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\IpGridView;
use hipanel\modules\hosting\menus\IpDetailMenu;
use hipanel\modules\hosting\models\Ip;
use hipanel\widgets\Box;
use hipanel\widgets\ModalButton;
use hipanel\widgets\Pjax;
use hiqdev\menumanager\widgets\DetailMenu;
use yii\helpers\Html;

/**
 * @var $model Ip
 */
$this->title = $model->ip;
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:hosting', 'IP addresses'), 'url' => ['index']];
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
            <?= IpDetailMenu::create(['model' => $model])->render(DetailMenu::class) ?>
        </div>
        <?php Box::end(); ?>
    </div>

    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <?php
                $box = Box::begin(['renderBody' => false]);
                $box->beginHeader();
                echo $box->renderTitle(Yii::t('hipanel', 'Detailed information'));
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
