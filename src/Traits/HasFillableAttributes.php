<?php

namespace App\Traits;

trait HasFillableAttributes
{
    public function getFillableAttributes(){
        return $this->fillable ?? [];
    }
}
