<?php
class Controller{
    function __construct(){
        $this->view = new View();
    }

    protected function loadModel($name){
        echo $name;
    }
}