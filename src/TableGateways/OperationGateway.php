<?php


namespace Src\TableGateways;


use MongoDB\BSON\ObjectId;
use MongoDB\Collection;

class OperationGateway implements iGateway
{
    private $db;
    private $dbName;

    private $operations;

    public function __construct($db)
    {
        $this->db = $db;
        $this->dbName = getenv('DB_DATABASE'); // This is bad, but no idea how to solve it
                                                        // at the moment.
        /**
         * @var Collection
         */
        $this->operations = $this->db->{$this->dbName}->Operations;
    }

    public function findAll()
    {
        $result = $this->operations->find()->toArray();
        // If something won't work, there is probably need to serialize that
        return $result;
    }

    public function find($id)
    {
        $result = $this->operations->findOne(['_id' => new ObjectId($id)]);
        return $result;
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