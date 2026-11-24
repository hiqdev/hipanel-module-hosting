<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\hosting\models\AccountCopyForm;
use hipanel\modules\server\widgets\combo\ServerCombo;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var AccountCopyForm $model
 * @var array|null $result
 */

$this->title = Yii::t('hipanel:hosting:account', 'Copy accounts');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:hosting', 'Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

/// servers and clients of this form are independent of each other
$serverCombo = ['filter' => [], 'pluginOptions' => []];
$objectLabels = [
    'account' => Yii::t('hipanel:hosting', 'Accounts'),
    'domain' => Yii::t('hipanel:hosting:account', 'Domains'),
    'cron' => Yii::t('hipanel:hosting:account', 'Crons'),
    'db' => Yii::t('hipanel:hosting:account', 'DBs'),
    'mail' => Yii::t('hipanel:hosting:account', 'Mails'),
];

?>

<div class="row">
    <div class="col-md-6">
        <?php if ($result !== null) : ?>
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('hipanel:hosting:account', 'Copied') ?></h3>
                </div>
                <div class="box-body no-padding">
                    <table class="table table-condensed copy-result">
                        <?php foreach ($result as $object => $stat) : ?>
                            <tr>
                                <th><?= Html::encode($objectLabels[$object] ?? $object) ?></th>
                                <td><?= Html::encode($stat['count'] ?? 0) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                </div>
            </div>
        <?php endif ?>

        <?php $form = ActiveForm::begin(['id' => 'account-copy-form']) ?>
        <div class="box box-danger">
            <div class="box-body">
                <div class="callout callout-warning">
                    <?= Yii::t('hipanel:hosting:account', 'Accounts, domains, crons and DBs are copied to the new server, mails are moved there. Files and DB data are not copied.') ?>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'old_server')->widget(ServerCombo::class, $serverCombo) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'new_server')->widget(ServerCombo::class, $serverCombo) ?>
                        <?= $form->field($model, 'is_dedicated')->checkbox() ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'old_client')->widget(ClientCombo::class) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'new_client')->widget(ClientCombo::class) ?>
                    </div>
                </div>

                <?= $form->field($model, 'old_accounts') ?>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'copy_accounts')->checkbox() ?>
                        <?= $form->field($model, 'copy_domains')->checkbox() ?>
                        <?= $form->field($model, 'copy_backuping')->checkbox() ?>
                        <?= $form->field($model, 'disable_dns')->checkbox() ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'copy_crontab')->checkbox() ?>
                        <?= $form->field($model, 'copy_dbs')->checkbox() ?>
                        <?= $form->field($model, 'move_mails')->checkbox() ?>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <?= Html::submitButton(Yii::t('hipanel:hosting:account', 'Copy'), [
                    'class' => 'btn btn-success',
                    'data-confirm' => Yii::t('hipanel:hosting:account', 'Are you sure you want to copy the accounts?'),
                ]) ?>
                <?= Html::a(Yii::t('hipanel', 'Cancel'), ['index'], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
