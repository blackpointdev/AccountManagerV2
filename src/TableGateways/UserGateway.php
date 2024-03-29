<?php


namespace Src\TableGateways;


use MongoDB\BSON\ObjectId;

class UserGateway implements iGateway
{
    private $db = null;
    private $dbName;

    public function __construct($db)
    {
        $this->db = $db;
        $this->dbName = getenv('DB_DATABASE');
    }

    public function findAll()
    {
        $users = $this->db->{$this->dbName}->Users;
        return $users->find()->toArray();
    }

    public function find(ObjectId $id)
    {
        // TODO: Implement find() method.
    }

    public function insert(array $input)
    {
        // TODO: Implement insert() method.
    }

    public function update(ObjectId $id, array $input)
    {
        // TODO: Implement update() method.
    }

    public function delete(ObjectId $id)
    {
        // TODO: Implement delete() method.
    }
}