<?php

namespace Juninho\CarrinhosCompras;

use Exception;
use FTP\Connection;
use Juninho\CarrinhosCompras\core\Database;

class Model
{

    private $connection;

    public function initConnection(){
        $this->connection = new Database();
    }

    public function insert($request, $table){
        if(!$this->connection instanceof Database) throw new Exception("Inicie a conexão com o banco de dados");
        $mysqli = ('insert into'. $table. 'values' . $request);
        $this->connection->getConnection($mysqli);
    }

    public function list($where, $table, $columns){
        if(!$this->connection instanceof Database) throw new Exception("Inicie a conexão com o banco de dados");
        $mysqli = ('select'.$columns.'from'.$table.'where'.$where);
        $this->connection->getConnection($mysqli);
    }

    public function update($request, $table, $where){
        if(!$this->connection instanceof Database) throw new Exception("Inicie a conexão com o banco de dados");
        $mysqli = ('update'.$table.'set'.$request. 'where'.$where);
        $this->connection->getConnection($mysqli);
    }

    public function delete($table, $where){
        if(!$this->connection instanceof Database) throw new Exception("Inicie a conexão com o banco de dados");
        $mysqli = ('delete from'.$table. 'where' . $where);
        $this->connection->getConnection($mysqli);
    }
}
