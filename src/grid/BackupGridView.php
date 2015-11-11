<?php

namespace hipanel\modules\hosting\grid;

use hipanel\grid\MainColumn;
use hipanel\modules\server\grid\ServerColumn;

class BackupGridView extends \hipanel\grid\BoxedGridView
{
    static public function defaultColumns()
    {
        return [
            'backup' => [
                'class' => MainColumn::className(),
                'filterAttribute' => 'backup_like',
            ],
            'server' => [
                'class' => ServerColumn::className(),
            ],
            'account' => [
                'class' => AccountColumn::className()
            ],
        ];
    }
}
