/**
 * Created by tofid on 25.11.15.
 */
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
                styling: 'bootstrap3',
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
