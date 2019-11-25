<?php


namespace Src\TableGateways;


use MongoDB\BSON\ObjectId;


/**
 * Interface iGateway
 *
 * Standard CRUD API interface.
 *
 * @package Src\TableGateways
 */
interface iGateway
{
    public function findAll();
    public function find(ObjectId $id);
    public function insert(Array $input);
    public function update(ObjectId $id, Array $input);
    public function delete(ObjectId $id);

}