<?php

namespace Controller;

class Controller
{
    private $viewParams;
    
    public function __construct()
    {
        $this->viewParams = [];
    }

    public function JSON($data){
        header("Content-Type: application/json");
        echo json_encode($data);
    }

    public function JSONMessage($message){
        $res = new \stdClass();
        $res->message = $message;
        $this->JSON($res);
    }

    public function View($template){
        extract($this->viewParams);
        header("Content-Type: text/html");
        include("View/".$template.".php");
    }

    public function addViewParams($name,$value){
        $this->viewParams[$name] = $value;
    }
}
