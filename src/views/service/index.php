<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\ServiceGridView;

$this->title                    = Yii::t('hipanel/hosting', 'Services');
$this->params['breadcrumbs'][]  = $this->title;
$this->params['subtitle']       = array_filter(Yii::$app->request->get($model->formName(), [])) ? 'filtered list' : 'full list';

?>

<?= serviceGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $model,
    'columns'      => [
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
