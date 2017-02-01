<?php
/**
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\hosting\widgets\backup;

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
        if ($this->model->backuping_exists) {
            return $this->generateBackupingLink();
        } else {
            return $this->generateBackupingEnableLink();
        }
    }

    protected function getRealObjectId()
    {
        $id = $this->model->id;

        if ($this->model instanceof Hdomain) {
            $id = $this->model->isAlias() ? $this->model->vhost_id : $this->model->id;
        }

        return $id;
    }

    protected function generateBackupingLink()
    {
        $id = $this->getRealObjectId();

        $linkToBackup = Html::a('<i class="fa fa-archive" aria-hidden="true"></i>&nbsp;&nbsp;' .
            Yii::t('hipanel:hosting', 'Backup settings'), ['@backuping/view', 'id' => $id]);

        return $linkToBackup;
    }

    protected function generateBackupingEnableLink()
    {
        $text = '<i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;';
        $text .= Yii::t('hipanel:hosting', 'Enable backuping');

        $linkToBackup = Html::a($text, [sprintf('@%s/enable-backuping', $this->model->tableName())], [
            'data-method' => 'POST',
            'data-params' => [
                sprintf('%s[id]', ucfirst($this->model->tableName())) => $this->getRealObjectId(),
            ],
        ]);

        return $linkToBackup;
    }
}
