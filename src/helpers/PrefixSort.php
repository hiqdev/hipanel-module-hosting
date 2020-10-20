<?php

namespace hipanel\modules\hosting\helpers;

use PhpIP\IPBlock;

class PrefixSort
{
    public static function byKinship(array $models, ?int $id, array &$result): void
    {
        foreach ($models as $model) {
            if ($model->parent_id === $id) {
                $result[] = $model;
                self::byKinship($models, $model->id, $result);
            }
        }
    }

    public static function byCidr(array &$models): void
    {
        usort($models, static function ($a, $b): int {
            return $a->getIPBlock()->getNetworkAddress()->numeric() <=> $b->getIPBlock()->getNetworkAddress()->numeric();
        });
    }
}

