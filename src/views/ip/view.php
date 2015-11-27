<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\IpGridView;
use hipanel\modules\hosting\models\Ip;
use hipanel\widgets\Pjax;

/**
 * @var $model Ip
 */

$this->title = $model->ip;
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel/hosting', 'IP addresses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<? Pjax::begin(Yii::$app->params['pjax']) ?>
<div class="row">
    <div class="col-md-4">
        <?= IpGridView::detailView([
            'model' => $model,
            'columns' => [
                'ip',
                'tags',
                'counters',
                'links',
            ],
        ]) ?>
    </div>
</div>
<?php Pjax::end() ?>
