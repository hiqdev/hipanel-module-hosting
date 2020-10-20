<?php

namespace hipanel\modules\hosting\models\traits;

trait IPBlockTrait
{
    public function getIPBlock()
    {
        return IPBLock::create($this->ip);
    }
}