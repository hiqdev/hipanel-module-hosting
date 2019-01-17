<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\widgets\mail;

use hipanel\modules\hosting\models\Mail;
use hipanel\widgets\Label;
use Yii;

class Type extends Label
{
    /**
     * @var Mail
     */
    public $model;

    public $default = null;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $model = $this->model;
        if ($model->type === $model::TYPE_FORWARD_ONLY) {
            $this->label = Yii::t('hipanel:hosting', 'Forward only');
            $this->color = 'primary';
            $this->labelOptions = [
                'title' => Yii::t('hipanel:hosting', 'You can not login to this mailbox, but all messages will be forwarded to specified addresses'),
            ];
        } elseif ($model->type === $model::TYPE_BOX_WITH_FORWARDS) {
            $this->label = Yii::t('hipanel:hosting', 'Mailbox with forwards');
            $this->color = 'warning';
            $this->labelOptions = [
                'title' => Yii::t('hipanel:hosting', 'You can login this mailbox, also all the messages will be forwarded to specified addresses'),
            ];
        } else {
            $this->label = Yii::t('hipanel:hosting', 'Mailbox');
            $this->color = 'default';
            $this->labelOptions = [
                'title' => Yii::t('hipanel:hosting', 'You can login this mailbox'),
            ];
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

        return parent::renderLabel();
    }
}
