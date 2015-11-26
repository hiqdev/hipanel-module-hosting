<?php

namespace hipanel\modules\hosting\widgets\ip;

use hipanel\widgets\Label;
use Yii;

class IpTag extends Label
{
    public $tag = '';

    public function init()
    {
        $tag = $this->tag;

        if ($tag == 'static') {
            $class = 'success';
        } elseif ($tag == 'aux') {
            $class = 'default';
        } elseif ($tag == 'gateway') {
            $class = 'primary';
        } elseif ($tag == 'movement') {
            $class = 'danger';
        } elseif ($tag == 'anycast') {
            $class = 'info';
        } else {
            $class = 'default';
        }

        $this->color = $class;
        $this->label = Yii::t('hipanel/hosting', $tag);
        parent::init();
    }
}
