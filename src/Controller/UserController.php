<?php


namespace Src\Controller;

use Src\TableGateways\UserGateway;

class UserController
{
    private $db;
    private $requestMethod;
    private $userId;

    private $userGateway;

    public function __construct($db, $requestMethod, $userId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;

        $this->userGateway = new UserGateway($db);
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
//        return json_encode($result);
    }


}