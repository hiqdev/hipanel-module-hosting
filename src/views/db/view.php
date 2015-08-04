<?php

use hipanel\modules\hosting\grid\DbGridView;
use hipanel\widgets\Box;
use yii\bootstrap\Modal;
use yii\helpers\Html;

$this->title    = $model->name;
$this->subtitle = Yii::t('app', 'database detailed information') . ' #' . $model->id;
$this->breadcrumbs->setItems([
    ['label' => 'Databases', 'url' => ['index']],
    $this->title,
]);
?>

<div class="row">
    <div class="col-md-3">
        <?php Box::begin(); ?>
        <div class="profile-user-img text-center">
            <i class="fa fa-database fa-5x"></i>
        </div>
        <p class="text-center">
            <span class="profile-user-role"><?= $model->name ?></span>
            <br>
            <span class="profile-user-name"><?= $model->client . ' / ' . $model->seller; ?></span>
        </p>

        <div class="profile-usermenu">
            <ul class="nav">
                <li>
                    <?= Html::a('<i class="fa fa-lock"></i>' . Yii::t('app', 'Change password'), '#', [
                        'data-toggle' => 'modal',
                        'data-target' => "#modal_{$model->id}_password",
                    ]); ?>

                    <?php
                    $model->scenario = 'set-password';
                    $form            = \yii\bootstrap\ActiveForm::begin([
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
                        'id'            => "modal_{$model->id}_password",
                        'toggleButton'  => false,
                        'header'        => Html::tag('h4', Yii::t('app', 'Change database password')),
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
                </li>
                <li>
                    <?= Html::a('<i class="fa "></i>' . Yii::t('app', 'Truncate'), '#', [
                        'data-toggle' => 'modal',
                        'data-target' => "#modal_{$model->id}_truncate",
                    ]); ?>

                    <?php
                    echo Html::beginForm(['truncate'], "POST", ['data' => ['pjax' => 1, 'pjax-push' => 0], 'class' => 'inline']);
                    echo Html::activeHiddenInput($model, 'id');
                    Modal::begin([
                        'id'            => "modal_{$model->id}_truncate",
                        'toggleButton'  => false,
                        'header'        => Html::tag('h4', Yii::t('app', 'Confirm database truncating')),
                        'headerOptions' => ['class' => 'label-warning'],
                        'footer'        => Html::button(Yii::t('app', 'Truncate database'), [
                            'class'             => 'btn btn-warning',
                            'data-loading-text' => Yii::t('app', 'Truncating database...'),
                            'onClick'           => new \yii\web\JsExpression("
                                $(this).closest('form').trigger('submit');
                                $(this).button('loading');
                            ")
                        ])
                    ]);
                    echo Yii::t('app',
                        'Are you sure that you want to truncate database {name}? All tables will be dropped, including data and structure!',
                        ['name' => $model->name]);
                    Modal::end();
                    echo Html::endForm();
                    ?>
                </li>
                <li>
                    <?= Html::a('<i class="fa fa-trash-o"></i>' . Yii::t('app', 'Delete'), '#', [
                        'data-toggle' => 'modal',
                        'data-target' => "#modal_{$model->id}_delete",
                    ]); ?>

                    <?php
                    echo Html::beginForm(['delete'], "POST", ['data' => ['pjax' => 1, 'pjax-push' => 0], 'class' => 'inline']);
                    echo Html::activeHiddenInput($model, 'id');
                    Modal::begin([
                        'id'            => "modal_{$model->id}_delete",
                        'toggleButton'  => false,
                        'header'        => Html::tag('h4', Yii::t('app', 'Confirm database deleting')),
                        'headerOptions' => ['class' => 'label-danger'],
                        'footer'        => Html::button(Yii::t('app', 'Delete database'), [
                            'class'             => 'btn btn-danger',
                            'data-loading-text' => Yii::t('app', 'Deleting database...'),
                            'onClick'           => new \yii\web\JsExpression("
                                    $(this).closest('form').trigger('submit');
                                    $(this).button('loading');
                                ")
                        ])
                    ]);
                    echo Yii::t('app',
                        'Are you sure, that you want to delete database {name}? All tables will be dropped, all data will be lost.',
                        ['name' => $model->name]);
                    Modal::end();
                    echo Html::endForm();
                    ?>
                </li>
            </ul>
        </div>
        <?php Box::end(); ?>
    </div>

    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <?php
                $box = Box::begin(['renderBody' => false]);
                $box->beginHeader();
                echo $box->renderTitle(Yii::t('app', 'Database information'));
                $box->endHeader();
                $box->beginBody();
                echo DbGridView::detailView([
                    'boxed'   => false,
                    'model'   => $model,
                    'columns' => [
                        'seller_id',
                        'client_id',
                        ['attribute' => 'name'],
                        'service_ip',
                        'description',
                    ],
                ]);
                $box->endBody();
                $box::end();
                ?>
            </div>
        </div>
    </div>
</div>