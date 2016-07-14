<?php

/*
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\widgets\backup;

use hipanel\modules\hosting\models\Backuping;
use hipanel\modules\hosting\models\Hdomain;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class BackupGridRow extends Widget
{
    /**
     * @var \hipanel\base\Model
     */
    public $model;

    public function run()
    {
        $id = $this->model->id;

        if ($this->model instanceof Hdomain) {
            $id = $this->model->isAlias() ? $this->model->vhost_id : $this->model->id;
        }

        $linkToBackup = Html::a('<i class="fa fa-archive" aria-hidden="true"></i>&nbsp;&nbsp;' .
            Yii::t('hipanel/hosting', 'Backup settings'), ['@backuping/view', 'id' => $id]);

        return $linkToBackup;
    }
}
