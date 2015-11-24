<?php
/**
 * @link    http://hiqdev.com/hipanel-module-hosting
 * @license http://hiqdev.com/hipanel-module-hosting/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\helpers\Url;
use hipanel\modules\hosting\grid\CrontabGridView;
use hiqdev\assets\autosize\AutosizeAsset;
use hiqdev\xeditable\widgets\XEditable;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

AutosizeAsset::register($this);

$this->title = Yii::t('app', 'Cron ID:{id}', ['id' => $model->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Crons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$model->scenario = 'update';

$this->registerJs(<<<JS
;(function ($, window, document, undefined) {
    var pluginName = "crontabFetch",
    defaults = { textareaSelector: 'crontab'};

    function Plugin(element, options) {
        this.element = element;
        this.crontab = {};
        this.settings = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    Plugin.prototype = {
        init: function () {
            var _this = this;
            this.crontab.id = $(this.element).find('.id-hidden-input').val();
            this.textarea = $(this.element).find('.crontab-input');
            this.crontab.fetchButton = $(this.element).find('#refresh-crontab-field');

            this.crontab.fetchButton.on('click', function() {
                _this._requestFetch();
            });

            return this;
        },
        _loadingOn: function() {
            var _this = this;
            _this.textarea.prop('readonly', true);
            _this.crontab.fetchButton.prop('disabled', true);
            jQuery('.box .overlay').show();
        },
        _loadingOff: function() {
            var _this = this;
            _this.textarea.prop('readonly', false);
            _this.crontab.fetchButton.prop('disabled', false);
            jQuery('.box .overlay').hide();
        },
        _requestFetch: function () {
            var _this = this;

            var data = {};
            data[this.crontab.id] = {id: this.crontab.id};

            $.ajax({
                url: "request-fetch",
                dataType: 'json',
                method: 'post',
                data: { id: this.crontab.id },
                beforeSend: function () {
                    _this._loadingOn();
                },
                success: function (response) {
                    if (response.error) {
                        _this.showError(response.error._error);
                        _this._loadingOff();
                    }
                    _this.startQuerier();
                }
            });


            return this;
        },
        startQuerier: function () {
            var _this = this;
            setTimeout(function() { _this.query(); }, 1000);

            return this;
        },
        query: function () {
            var _this = this;

            var data = {};
            data[this.crontab.id] = {id: this.crontab.id};

            $.ajax({
                url: "get-request-state",
                dataType: 'json',
                method: 'post',
                data: { id: this.crontab.id },
                success: function (data) {
                    var state = data['request_state'];

                    if (state == "progress" || state == "new") {
                        _this.startQuerier();
                    } else if (state == 'error') {
                        _this.errorTextarea();
                    } else {
                        _this.updateTextarea();
                    }

                    return true;
                }
            });
        },
        updateTextarea: function() {
            var _this = this;

            var data = {};
            data[this.crontab.id] = {id: this.crontab.id};

            $.ajax({
                url: "get-info",
                dataType: 'json',
                tethod: 'post',
                data: { id: this.crontab.id },
                success: function (data) {
                    _this._loadingOff();
                    if (data['crontab']) {
                        _this.textarea.val(data['crontab']);
                    }
                }
            });

            return this;
        },
        errorTextarea: function() {
            showErrorMainHint('{LaNG:Error occurred during fetching crontab from server. <br>Maybe server is offline. Please, contact support.}');
        },
        showError: function(message) {
            new PNotify({
                title: 'Error',
                text: message,
                type: 'error'
            });
        }
    };
    $.fn[ pluginName ] = function (options) {
        this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName, new Plugin(this, options));
            }
        });

        return this;
    };
})(jQuery, window, document);
JS
, \yii\web\View::POS_END);


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
                    <?= Html::button('<i class="fa fa-refresh"></i> ' . Yii::t('app', 'Refresh'), [
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
