<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\RequestGridView;
use hipanel\widgets\Pjax;
use yii\helpers\Html;

$this->title = Html::encode(Yii::t('app', 'Request') . ' #' . $model->id);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Requests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">

    <div class="col-md-4">
        <?= RequestGridView::detailView([
            'model' => $model,
            'columns' => [
                'classes',
                'server',
                'account',
                'object',
                'time',
                'state',
            ],
        ]) ?>
    </div>

</div>

