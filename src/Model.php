<?php

namespace Juninho\CarrinhosCompras;

use Exception;
use Juninho\CarrinhosCompras\core\Database;
use Juninho\CarrinhosCompras\Traits\HasFillableAttributes;
use Juninho\CarrinhosCompras\Traits\HasId;
use Juninho\CarrinhosCompras\Traits\HasTables;

class Model
{
    use HasFillableAttributes;
    use HasTables;
    use HasId;
    private $connection;

    public function initConnection(){
        if(!$this->getTable()) throw new Exception("Não há uma tabela existente.");
        $this->connection = new Database();
    }
    private function insert($table, $columns, $values){
        $query = ('insert into '. $table.' ('.implode(",", $columns).') values ('.implode(",", $values).')');
        $result = mysqli_query($this->connection->getConnection(), $query);
        return $result ? true : false;
    }

    private function update($table, $columns, $values){
        // $columns = [name, description, price]
        // $values = [caneta, azul, 12.1]
        // name = caneta, description = azul, price = 12.1
        foreach ($columns as $key => $column){
            $set[] = " ".$column." = ".$values[$key]."";
        } 

        $query = ('update '.$table.' set '.implode(',', $set). ' where id='. $this->id());
        echo $query;
        $result = mysqli_query($this->connection->getConnection(), $query);
        return $result ? true : false;
    }

    public function save(){
        if(!$this->connection instanceof Database) throw new Exception("Inicie a conexão com o banco de dados");   
        $model = $this;
        $columns = $model->getFillableAttributes();
        $table = $model->getTable();
        $values = array_map(function($column) use ($model){
            return "'".$model->$column . "'";
        }, $columns);

        if(!$this->id()){
            $this->insert($table, $columns, $values);
        }else{
            $this->update($table, $columns, $values);
        }
    }

    public function find($id){
        if(!$this->connection instanceof Database) throw new Exception("Inicie a conexão com o banco de dados");   
        $query = ("select * from ".$this->getTable()." where id =".$id );
        $this->connection->getConnection();
        $result = mysqli_query($this->connection->getConnection(), $query);
        return $result;
    }

    public function all(){
        if(!$this->connection instanceof Database) throw new Exception("Inicie a conexão com o banco de dados");
        $model = $this;   
        $table = $model->getTable();
        $query = ('select * from '.$table);
        $this->connection->getConnection();
        $result = mysqli_query($this->connection->getConnection(), $query);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    public function delete($where){
        if(!$this->connection instanceof Database) throw new Exception("Inicie a conexão com o banco de dados");
        $model = $this;
        $table = $model->getTable();
        $query = ('delete from '.$table. ' where id=' . $where);
        echo $query;
        $this->connection->getConnection();
    }
}
