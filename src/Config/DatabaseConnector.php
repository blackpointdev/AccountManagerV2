<?php
namespace Src\Config;
use MongoDB\Client;
use MongoDB\Driver\Exception;
class DatabaseConnector
{
    private $dbConnection;

    public function __construct()
    {
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $user = getenv('DB_USERNAME');
        $pass = getenv('DB_PASSWORD');

        if ($user == "" or $pass == "")
        {
            $connection_string = "mongodb://" . $host . ":" . $port;
        }
        else
        {
            $connection_string = "mongodb+srv://" . $user . ":" . $pass . "@" . $host;
        }

        try
        {
            $this->dbConnection = new Client($connection_string);
        }
        catch (Exception\RuntimeException $e)
        {
            echo "Connection error: " . $e->getMessage();
        }
    }

    public function getConnection(): Client
    {
        return $this->dbConnection;
    }
}