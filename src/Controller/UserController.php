<?php


namespace Src\Controller;

use Src\TableGateways\UserGateway;

class UserController implements iController
{
    private $db;
    private $requestMethod;
    private $userId;

    private $userGateway;

    public function __construct($dbConnection, $requestMethod = null, $userId = null)
    {
        $this->db = $dbConnection;
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;

        $this->userGateway = new UserGateway($dbConnection);
    }


    public function processRequest()
    {
        switch ($this->requestMethod)
        {
            case 'GET':
                $response = $this->getAllUsers();
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    public function getAllUsers()
    {
        $result = $this->userGateway->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }


    public function setRequestMethod($requestMethod)
    {
        $this->requestMethod = $requestMethod;
    }

    public function setTargetId($id)
    {
        $this->userId = $id;
    }
}