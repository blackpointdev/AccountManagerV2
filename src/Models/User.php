<?php

// Composer autoloader
//require '../vendor/autoload.php';

class User
{
    // DB stuff
    private $conn;
    private $table_name = "Users";

    // Object properties
    private $id;
    private $name;
    private $email;
    private $password;
    private $role;

    private $balance;

    public function __construct(MongoDB\Client $db)
    {
        $this->conn = $db;
    }

    // Read all users from database (IT SHOULDN'T BE AVAILABLE FOR PUBLIC!!!!!)
    public function read()
    {
        $users = $this->conn->account_manager->{$this->table_name};
        return $users->find()->toArray();
    }
}