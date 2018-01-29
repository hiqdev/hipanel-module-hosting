<?php

namespace hipanel\modules\hosting\grid;

use hiqdev\higrid\representations\RepresentationCollection;
use Yii;

class HdomainRepresentations extends RepresentationCollection
{
    protected function fillRepresentations()
    {
        $this->representations = array_filter([
            'common' => [
                'label' => Yii::t('hipanel', 'common'),
                'columns' => [
                    'checkbox',
                    'hdomain_with_aliases',
                    'client',
                    'seller',
                    'account',
                    'server',
                    'state',
                    'ip',
                    'service',
                ],
            ],
        ]);
    }
}
