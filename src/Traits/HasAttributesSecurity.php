<?php

namespace App\Traits;

trait HasAttributesSecurity
{
    public function getAccessibleAtributtes(){
        return $this->accessible;
    }
}
