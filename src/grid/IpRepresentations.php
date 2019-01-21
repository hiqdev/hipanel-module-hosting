<?php

namespace hipanel\modules\hosting\grid;

use hiqdev\higrid\representations\RepresentationCollection;
use Yii;

class IpRepresentations extends RepresentationCollection
{
    protected function fillRepresentations()
    {
        $this->representations = array_filter([
            'common' => [
                'label' => Yii::t('hipanel', 'common'),
                'columns' => [
                    'actions',
                    'ip',
                    'note',
                    'tags',
                    'counters',
                    'links',
                    'client',
                    'type',
                ],
            ],
        ]);
    }
}
