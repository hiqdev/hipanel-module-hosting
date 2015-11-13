<?php

namespace hipanel\modules\hosting\widgets\combo;

use hiqdev\combo\Combo;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

class MultipleMailCombo extends MailCombo
{
    /** @inheritdoc */
    public function getPluginOptions($options = [])
    {
        return parent::getPluginOptions(ArrayHelper::merge([
            'select2Options' => [
                'multiple' => true,
                'tokenSeparators' => [', ', ' '],
                'tags' => true,
                'createSearchChoice' => new JsExpression(/** @lang JavaScript */'
                    function (term, data) {
                        if ($(data).filter(function () {
                            return this.text.localeCompare(term) === 0;
                        }).length === 0) {
                            if (term.match(/^[0-9a-zA-Z\._+-]+@([0-9a-z][0-9a-z_-]*\.)+[0-9a-z][0-9a-z-]*$/i)) {
                                return {
                                    id: term,
                                    text: term
                                };
                            }
                        }
                    }
                ')
            ]
        ], $options));
    }
}