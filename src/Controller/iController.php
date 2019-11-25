<?php


namespace Src\Controller;


interface iController
{
    public function processRequest();

    public function setRequestMethod($requestMethod);
    public function setTargetId($id);

}