<?php

namespace hipanel\modules\hosting\widgets\mail;

use hipanel\widgets\Label;
use Yii;
use yii\base\Model;

class Type extends Label
{
    /**
     * @var Model
     */
    public $model;

    public $default = null;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if ($this->model->is_alias) {
            $this->label = Yii::t('app', 'Forward only');
            $this->color = 'primary';
            $this->labelOptions = [
                'title' => Yii::t('app', 'You can not login ...') // TODO
            ];
        } elseif ($this->model->forwards) {
            $this->label = Yii::t('app', 'Mailbox with forwards');
            $this->color = 'warning';
        } else {
            $this->label = Yii::t('app', 'Mailbox');
            $this->color = 'default';
        }

        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    protected function renderLabel()
    {
        if ($this->color === null) {
            return;
        }

        parent::renderLabel();
    }
}
