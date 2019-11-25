<?php


namespace Src\TableGateways;


class UserGateway
{
    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $users = $this->db->{'account_manager'}->Users;
        return $users->find()->toArray();
    }
}