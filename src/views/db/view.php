<?php

use hipanel\modules\hosting\grid\DbGridView;
use hipanel\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Html;

$this->title                   = Html::encode($model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Databases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<? Pjax::begin(Yii::$app->params['pjax']); ?>
    <div class="row">
        <div class="col-md-4">
            <?= DbGridView::detailView([
                'model'   => $model,
                'columns' => [
                    'seller_id',
                    'client_id',
                    ['attribute' => 'name'],
                    'service_ip',
                    'description',
                ],
            ]) ?>
        </div>

        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header"><?= \Yii::t('app', 'DB management') ?></div>
                <div class="box-body">
                    <?php
                    $model->scenario = 'set-password';
                    $form = \yii\bootstrap\ActiveForm::begin([
                        'action'  => ['set-password'],
                        'options' => ['data-pjax' => 1, 'data-pjax-push' => 0, 'class' => 'inline']
                    ]);
                    $this->registerJs("$('#{$form->id}').on('beforeSubmit', function (event) {
                        if ($(this).data('yiiActiveForm').validated) {
                            return $(this).find('[type=\"submit\"]').button('loading');
                        }
                    });");
                    echo Html::activeHiddenInput($model, 'id');
                    Modal::begin([
                        'options'       => [
                            'data-backdrop' => 0
                        ],
                        'toggleButton'  => [
                            'label' => Yii::t('app', 'Change password'),
                            'class' => 'btn btn-default',
                        ],
                        'header'        => Html::tag('h4', Yii::t('app', 'Change DB password')),
                        'headerOptions' => ['class' => 'label-default'],
                        'footer'        => Html::submitButton(Yii::t('app', 'Change password'), [
                            'class'             => 'btn btn-primary',
                            'data-loading-text' => Yii::t('app', 'Changing password...'),
                        ])
                    ]);
                    echo $form->field($model, 'password')->widget(\hipanel\widgets\PasswordInput::className(), [
                        'model'     => $model,
                        'attribute' => 'password'
                    ]);
                    Modal::end();
                    $form->end();
                    ?>

                    <?php
                    echo Html::beginForm(['truncate'], "POST", ['data' => ['pjax' => 1, 'pjax-push' => 0], 'class' => 'inline']);                   echo Html::activeHiddenInput($model, 'id');
                    echo Html::activeHiddenInput($model, 'id');
                    Modal::begin([
                        'options'       => [
                            'data-backdrop' => 0
                        ],
                        'toggleButton'  => [
                            'label' => Yii::t('app', 'Truncate'),
                            'class' => 'btn btn-warning',
                        ],
                        'header'        => Html::tag('h4', Yii::t('app', 'Confirm DB truncating')),
                        'headerOptions' => ['class' => 'label-warning'],
                        'footer'        => Html::button(Yii::t('app', 'Truncate DB'), [
                            'class'             => 'btn btn-warning',
                            'data-loading-text' => Yii::t('app', 'Truncating DB...'),
                            'onClick'           => new \yii\web\JsExpression("
                                $(this).closest('form').trigger('submit');
                                $(this).button('loading');
                            ")
                        ])
                    ]);
                    echo Yii::t('app', 'The database {name} will be fully fully truncated. All tables will be dropped, including data and structure. Are you sure?', ['name' => $model->name]);
                    Modal::end();
                    echo Html::endForm();
                    ?>

                    <?php
                    echo Html::beginForm(['delete'], "POST", ['data' => ['pjax' => 1, 'pjax-push' => 0], 'class' => 'inline']);
                    echo Html::activeHiddenInput($model, 'id');
                    Modal::begin([
                        'options'       => [
                            'data-backdrop' => 0
                        ],
                        'toggleButton'  => [
                            'label' => Yii::t('app', 'Delete'),
                            'class' => 'btn btn-danger',
                        ],
                        'header'        => Html::tag('h4', Yii::t('app', 'Confirm DB deleting')),
                        'headerOptions' => ['class' => 'label-danger'],
                        'footer'        => Html::button(Yii::t('app', 'Deleting DB'), [
                            'class'             => 'btn btn-danger',
                            'data-loading-text' => Yii::t('app', 'Deleting DB...'),
                            'onClick'           => new \yii\web\JsExpression("
                                $(this).closest('form').trigger('submit');
                                $(this).button('loading');
                            ")
                        ])
                    ]);
                    echo Yii::t('app', 'The database {name} will be deleted. All tables will be dropped, all data will be lost. Are you sure?', ['name' => $model->name]);
                    Modal::end();
                    echo Html::endForm();
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php Pjax::end();
