<?php

namespace App\Models;

use PDOException;

class POI
{

    private $id;
    private $nome;
    private $x;
    private $y;

    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($attr, $value)
    {
        $this->$attr = $value;
        return $this;
    }

    public function cadastra($db)
    {
        $query = 'insert into POIs(nome, x, y) values(:nome, :x, :y)';
        $stmt = $db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':x', $this->__get('x'));
        $stmt->bindValue(':y', $this->__get('y'));
        $stmt->execute();
        return $db->errorInfo();
    }

    public function getAll($db){
        $query = 'select id, nome, x, y from pois';
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
