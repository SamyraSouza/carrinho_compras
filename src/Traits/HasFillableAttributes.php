<?php

namespace Juninho\CarrinhosCompras\Traits;

trait HasFillableAttributes
{
    public function getFillableAttributes(){
        return $this->fillable ?? [];
    }
}
