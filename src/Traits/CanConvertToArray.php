<?php

namespace App\Traits;

use App\Model;
use App\Products;

trait CanConvertToArray
{
    /*
    * Convert a object to an associative array
    * @return array
    * @params 
    */
    public function toArray(){
        // Inicia o array que vai ser retornado
        $data = [];

        // percorre pelos atributos  permitidos do objeto ['id', 'numero', 'nome']
        foreach($this->getAccessibleAtributtes() as $column){
            // é um array ?
            if(!is_array($this->$column)) {
                // se não, adiciona o valor direto
                $data[$column] = $this->$column;
            } 
            // é um objeto do tipo Model ?
            else if ($this->$column instanceof Model) {
                // se sim, converte o objeto para um array
                $data[$column] = $this->convertObjectToArray($this->$column);
            } 
            // se não é um obejto do tipo model ou é array
            else {
                //percorre os valores
                foreach($this->$column as $indexOfArray) {
                    // é um objeto do tipo model ?
                    if($indexOfArray instanceof Model) {
                        // se sim, converte para array
                        $data[$column][] = $this->convertObjectToArray($indexOfArray);
                    } else {
                        //se não, adiciona direto ao array que vai ser retornado
                        $data[$column] = $this->$column;
                    }
                }
            }
        }
        //retorna o array pronto :D
        return $data;
    }

    protected function convertObjectToArray($object) {
        $objectData = [];

        foreach($object->getAccessibleAtributtes() as $column){
            $objectData[$column] = $object->$column; 
        }

        return $objectData;
    }
}
