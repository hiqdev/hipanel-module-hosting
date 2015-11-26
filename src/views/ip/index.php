<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\IpGridView;

$this->title = Yii::t('hipanel/hosting', 'IP addresses');
$this->params['breadcrumbs'][] = $this->title;
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? 'filtered list' : 'full list';

?>

<?= ipGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
    'ipTags' => $ipTags,
    'columns' => [
        'seller_id',
        'client_id',
        'ip',
        'tags',
        'counters',
        'links',
        'actions',
    ],
]) ?>
