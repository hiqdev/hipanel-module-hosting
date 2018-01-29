<?php

namespace hipanel\modules\hosting\grid;

use hiqdev\higrid\representations\RepresentationCollection;
use Yii;

class RequestRepresentations extends RepresentationCollection
{
    protected function fillRepresentations()
    {
        $this->representations = array_filter([
            'common' => [
                'label' => Yii::t('hipanel', 'common'),
                'columns' => [
                    'checkbox',
                    'classes',
                    'server',
                    'account',
                    'actions',
                    'object',
                    'time',
                    'state',
                ],
            ],
        ]);
    }
}
