<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\widgets\db;

use hipanel\widgets\Label;
use Yii;

class State extends Label
{
    public $model = [];

    public function init()
    {
        $state = $this->model->state;
        if ($state === 'ok') {
            $class = 'info';
        } elseif ($state === 'blocked') {
            $class = 'danger';
        } else {
            $class = 'warning';
        }

        $this->color = $class;
        $this->label = Yii::t('hipanel:hosting', $this->model->state_label);
        parent::init();
    }
}
