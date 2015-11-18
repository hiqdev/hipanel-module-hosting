<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\hosting\grid\CrontabGridView;
use hipanel\widgets\Pjax;
use hiqdev\xeditable\widgets\XEditable;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Cron ID:{id}', ['id' => $model->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Crons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$model->scenario = 'update';
$this->registerCss("
.editableform .form-control {
    min-width: 600pt;
}
");
?>

<div class="row">
    <div class="col-md-12">
        <?= CrontabGridView::detailView([
            'model' => $model,
            'columns' => [
                'account',
                'server',
                'client',
                [
                    'attribute' => 'crontab',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return XEditable::widget([
                            'model' => $model,
                            'attribute' => 'crontab',
                            'pluginOptions' => [
                                'mode' => 'inline',
                                'type' => 'textarea',
                                'rows' => 20,
                                'select2Options' => [
                                    'width' => '50rem',
                                ],
                            ]
                        ]);
                    }
                ]
            ]
        ]) ?>
    </div>
</div>
