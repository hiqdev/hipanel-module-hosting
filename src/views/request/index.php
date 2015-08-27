<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\RequestGridView;

$this->title                    = Yii::t('app', 'Requests');
$this->params['breadcrumbs'][]  = $this->title;
$this->params['subtitle']       = array_filter(Yii::$app->request->get($model->formName(), [])) ? 'filtered list' : 'full list';

?>

<?= requestGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $model,
    'columns'      => [
        'checkbox',
        'seller',
        'client',
        'request'
    ],
]) ?>
