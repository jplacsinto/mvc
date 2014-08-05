<?php
class Help extends Controller{

    function __construct(){
        parent::__construct();
    }

    public function sample($arg = null){
        echo "Im the new function!";
        if(!is_null($arg)){
            echo $arg;
        }
    }

    public function other(){

    }
}