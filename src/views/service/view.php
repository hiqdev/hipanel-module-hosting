<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\ServiceGridView;
use hipanel\widgets\Pjax;
use yii\helpers\Html;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel/hosting', 'Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php Pjax::begin(Yii::$app->params['pjax']) ?>
<div class="row">
    <div class="col-md-4">
        <?= ServiceGridView::detailView([
            'model' => $model,
            'columns' => [
                'seller_id',
                'client_id',
                'service',
                'ip',
                'bin',
                'etc',
                'soft',
                'state',
            ],
        ]) ?>
    </div>
</div>
<?php Pjax::end() ?>
