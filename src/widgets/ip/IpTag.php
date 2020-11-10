<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\widgets\ip;

use hipanel\widgets\Label;
use Yii;

class IpTag extends Label
{
    public $tag = '';

    public function init()
    {
        $tag = $this->tag;

        if ($tag === 'static') {
            $class = 'success';
        } elseif ($tag === 'aux') {
            $class = 'default';
        } elseif ($tag === 'gateway') {
            $class = 'primary';
        } elseif ($tag === 'movement') {
            $class = 'danger';
        } elseif ($tag === 'anycast') {
            $class = 'info';
        } else {
            $class = 'default';
        }

        $this->color = $class;
        $this->label = Yii::t('hipanel:hosting', $tag);
        $this->tag = 'span';
        parent::init();
    }
}
