<?php

namespace App\Traits;

trait HasId
{
    protected $id;

    public function id(){
        return $this->id ?? 0;
    }
}
