<?php

namespace hipanel\modules\hosting\grid;

use hiqdev\higrid\representations\RepresentationCollection;
use Yii;

class BackupingRepresentations extends RepresentationCollection
{
    protected function fillRepresentations()
    {
        $this->representations = array_filter([
            'common' => [
                'label' => Yii::t('hipanel', 'common'),
                'columns' => [
                    'checkbox',
                    'main',
                    'client',
                    'account',
                    'server',
                    'backup_count',
                    'type',
                    'state_label',
                    'backup_last',
                    'total_du',
                ],
            ],
        ]);
    }
}
