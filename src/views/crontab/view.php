<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\helpers\Url;
use hipanel\modules\hosting\grid\CrontabGridView;
use hiqdev\assets\autosize\AutosizeAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

AutosizeAsset::register($this);
\hipanel\modules\hosting\assets\CrontabFetchAsset::register($this);

$this->title = Yii::t('hipanel/hosting', 'Cron ID: {id}', ['id' => $model->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel/hosting', 'Crons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$model->scenario = 'update';

Yii::$app->assetManager->forceCopy = true;

$this->registerJs(<<<JS
    autosize(document.getElementsByTagName('TEXTAREA')[0]);
    jQuery('#crontab-form').crontabFetch();
JS
, \yii\web\View::POS_READY);
?>

<div class="row">
    <div class="col-md-12">
        <?= CrontabGridView::detailView([
            'model' => $model,
            'columns' => [
                'account',
                'server',
                'client',
            ],
        ]) ?>
    </div>
    <div class="col-md-12">
        <?php
        $form = ActiveForm::begin([
            'id' => 'crontab-form',
            'action' => 'update',
            'enableClientValidation' => true,
            'validateOnBlur' => true,
            'enableAjaxValidation' => true,
            'validationUrl' => Url::toRoute(['validate-form', 'scenario' => 'update']),
        ]) ?>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('app', 'Crontab'); ?></h3>

                <div class="box-tools pull-right">
                    <?= Html::button('<i class="fa fa-refresh"></i> ' . Yii::t('hipanel', 'Refresh'), [
                        'id' => 'refresh-crontab-field',
                        'class' => 'btn btn-default btn-xs',

                    ]) ?>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?= Html::activeHiddenInput($model, "[$model->id]id", ['class' => 'id-hidden-input']) ?>
                <?= $form->field($model, "[$model->id]crontab")->textarea([
                    'rows' => 10,
                    'class' => 'form-control crontab-input',
                ])->label(false) ?>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-default']) ?>
            </div>
            <!-- box-footer -->
            <div class="overlay" style="display: none;">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
        <!-- /.box -->

        <?php ActiveForm::end(); ?>
    </div>
    <!-- /.col-md-12 -->
</div>
