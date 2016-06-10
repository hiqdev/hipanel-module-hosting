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
        $exists = Backuping::find()->where(['id' => $this->model->id])->exists();
        $backuping = new Backuping();
        $enableBackuping = Html::beginForm('@backuping/enable');
        $enableBackuping .= Html::activeHiddenInput($backuping, 'id', ['value' => $this->model->id]);
        $enableBackuping .= Html::submitButton('<i class="fa fa-archive" aria-hidden="true"></i>&nbsp;&nbsp;' .
            Yii::t('hipanel/hosting', 'Backup settings'), ['class' => 'btn btn-xs btn-success']);
        $enableBackuping .= Html::endForm();
//        $enableBackuping = Html::a('<i class="fa fa-archive" aria-hidden="true"></i>&nbsp;&nbsp;' .
//            Yii::t('hipanel/hosting', 'Backup settings'),
//            ['@backuping/enable', 'Backuping' => ['id' => $this->model->id]],
//            ['class' => 'btn btn-xs btn-success', 'data-method' => 'POST']);
        $linkToBackup = Html::a('<i class="fa fa-archive" aria-hidden="true"></i>&nbsp;&nbsp;' .
            Yii::t('hipanel/hosting', 'Backup settings'), ['/hosting/backuping/view', 'id' => $this->model->id]);

        return $exists ? $linkToBackup : $enableBackuping;
    }
}
