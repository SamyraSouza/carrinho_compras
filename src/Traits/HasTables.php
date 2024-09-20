<?php

namespace App\Traits;

trait HasTables
{
    public function getTable(){
        return $this->table ?? "";
    }
}
