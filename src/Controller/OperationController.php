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
                };
                break;
            case 'POST':
                $response = $this->createOperationFromRequest();
                break;

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

        foreach ($result as $operation)
        {
            $operation['date'] = $operation['date'].serialize();
        }
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

    private function createOperationFromRequest()
    {
        $input = (array) json_decode(file_get_contents("php://input", TRUE));
        if (!$this->validateOperation($input))
        {
            return $this->unprocessableEntityResponse();
        }
        $this->operationGateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
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

    private function validateOperation($input)
{
    if (!isset($input['name'])) {
        return false;
    }
    if (!isset($input['amount'])) {
        return false;
    }
    if (!isset($input['userID'])) {
        return false;
    }
    if (!isset($input['date'])) {
        return false;
    }

    return true;
}

    // ERRORS RESPONSES

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }
}