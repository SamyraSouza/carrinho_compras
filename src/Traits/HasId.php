<?php

namespace Juninho\CarrinhosCompras\Traits;

trait HasId
{
    protected $id;

    public function id(){
        return $this->id ?? 0;
    }
}
