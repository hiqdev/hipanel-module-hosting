<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\widgets\combo;

use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

class MultipleMailCombo extends MailCombo
{
    public $multiple = true;

    /** {@inheritdoc} */
    public function getPluginOptions($options = [])
    {
        return parent::getPluginOptions(ArrayHelper::merge([
            'select2Options' => [
                'tags' => true,
                'tokenSeparators' => [', ', ' '],
                'createTag' => new JsExpression(/** @lang JavaScript */'
                    function (query) {
                        var term = query.term;

                        if (term.match(/^[0-9a-zA-Z\._+-]+@([0-9a-z][0-9a-z_-]*\.)+[0-9a-z][0-9a-z-]*$/i)) {
                            return {
                                id: term,
                                text: term,
                                tag: true
                            };
                        }

                        return null;
                    }
                '),
            ],
        ], $options));
    }
}
