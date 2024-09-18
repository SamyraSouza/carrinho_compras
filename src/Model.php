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

    public function initConnection()
    {
        if (!$this->getTable()) throw new Exception("Não há uma tabela existente.");
        $this->connection = new Database();
    }
    
    private function insert($table, $columns, $values)
    {
        $query = ('insert into ' . $table . ' (' . implode(",", $columns) . ') values (' . implode(",", $values) . ')');

        $result = mysqli_query($this->connection->getConnection(), $query);

        return $result;
    }

    private function update($table, $columns, $values)
    {
        $set = [];
        foreach ($columns as $key => $column) {
            $set[] = " " . $column . " = " . $values[$key] . "";
        }

        $query = ('update ' . $table . ' set ' . implode(',', $set) . ' where id=' . $this->id());
        $result = mysqli_query($this->connection->getConnection(), $query);
        return $result ? true : false;
    }

    public function save()
    {
        if (!$this->connection instanceof Database) throw new Exception("Inicie a conexão com o banco de dados");
        $model = $this;
        $columns = $model->getFillableAttributes();
        $table = $model->getTable();
        $values = array_map(function ($column) use ($model) {
            return "'" . $model->$column . "'";
        }, $columns);

        if (!$this->id()) {
            return $this->insert($table, $columns, $values);
        } else {
            return $this->update($table, $columns, $values);
        }

    }

    public function find($id)
    {
        if (!$this->connection instanceof Database) throw new Exception("Inicie a conexão com o banco de dados");
        $query = ("select * from " . $this->getTable() . " where id =" . $id);
        $this->connection->getConnection();
        $result = mysqli_query($this->connection->getConnection(), $query);
        $result = mysqli_fetch_assoc($result);
        foreach ($result as $key => $value) {
            $this->$key = $value;
        }
    }

    public function all()
    {
        if (!$this->connection instanceof Database) throw new Exception("Inicie a conexão com o banco de dados");
        $model = $this;
        $table = $model->getTable();
        $query = ('select * from ' . $table);
        $this->connection->getConnection();
        $result = mysqli_query($this->connection->getConnection(), $query);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    public function delete()
    {
        if (!$this->connection instanceof Database) throw new Exception("Inicie a conexão com o banco de dados");
        $model = $this;
        $table = $model->getTable();
        $query = ('delete from ' . $table . ' where id=' . $this->id());
        $this->connection->getConnection();
        $result = mysqli_query($this->connection->getConnection(), $query);
        return $result ? true : false;
    }

    public function where($params = [])
    {
        if (!$this->connection instanceof Database) throw new Exception("Inicie a conexão com o banco de dados");
        $model = $this;
        $table = $model->getTable();
        $query_string = ("select * from " . $table . " ");
        $query_params = [];

        if (!empty($params)) {
            $query_string .= " where ";
            foreach ($params as $key => $value) {
                $query_params[] = $key . " = " . "'" . $value . "'";
            }
            $conditions = implode(" and ", $query_params);

            $query_string = $query_string . $conditions;
        }

        $result = mysqli_query($this->connection->getConnection(), $query_string);
        $data = [];
        
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    public function closeConnection()
    {
        $this->connection = null;
    }

    public function first(){
        if (!$this->connection instanceof Database) throw new Exception("Inicie a conexão com o banco de dados");
        $query = ("select * from ". $this->getTable()." order by id asc limit 1");
        $result = mysqli_query($this->connection->getConnection(), $query);
        $result = mysqli_fetch_assoc($result);
        foreach ($result as $key => $value) {
            $this->$key = $value;
        }
    }   
    public function last(){
        if (!$this->connection instanceof Database) throw new Exception("Inicie a conexão com o banco de dados");
        $query = ("select * from ". $this->getTable()." order by id desc limit 1");
        $result = mysqli_query($this->connection->getConnection(), $query);
        $result = mysqli_fetch_assoc($result);
        foreach ($result as $key => $value) {
            $this->$key = $value;
        }
    }
}
