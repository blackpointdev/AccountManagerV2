<?php


namespace Src\Controller;



use Src\TableGateways\OperationGateway;

class OperationController implements iController
{
    private $db;
    private $requestMethod;
    private $operationId;

    private $operationGateway;

    public function __construct($dbConnection, $requestMethod = null, $operationId = null)
    {
        $this->db = $dbConnection;
        $this->requestMethod = $requestMethod;
        $this->operationId = $operationId;

        $this->operationGateway = new OperationGateway($dbConnection);
    }

    public function processRequest()
    {
        switch ($this->requestMethod)
        {
            case 'GET':
                if($this->operationId) {
                    $response = $this->getOperation($this->operationId);
                } else {
                    $response = $this->getAllOperations();
                }
        }

        header($response['status_code_header']);
        if ($response['body'])
        {
            echo $response['body'];
        }
    }

    private function getAllOperations()
    {
        $result = $this->operationGateway->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getOperation($id)
    {
        $result = $this->operationGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
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
        $this->operationId = $id;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}