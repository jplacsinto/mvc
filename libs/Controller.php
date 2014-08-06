<?php
class Controller{

    protected $data = null;

    function __construct(){
        $this->view = new View();
    }
}