<?php

namespace hipanel\modules\hosting\widgets\backup;

use hipanel\modules\hosting\models\Backuping;
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
        $linkToBackup = Html::a('<i class="fa fa-archive" aria-hidden="true"></i>&nbsp;&nbsp;' .
            Yii::t('hipanel/hosting', 'Backup settings'), ['@backuping/view', 'id' => $this->model->id]);

        return $linkToBackup;
    }
}
