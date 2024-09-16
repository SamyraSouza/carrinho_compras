<?php

namespace Juninho\CarrinhosCompras\Traits;

trait HasTables
{
    public function getTable(){
        return $this->table ?? "";
    }
}
