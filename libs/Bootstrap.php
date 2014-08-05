<?php
class Bootstrap{
    function __construct(){

        $url = isset($_GET['url'])?$_GET['url']:null; //get the url
        $url = rtrim($url, '/'); //remove slashes
        $url = explode('/', $url);// explode by slashes

        //load the index controller and stop reading codes below if $url[0] is empty
        if(empty($url[0])){
            require "controllers/index.php";
            $controller = new Index();
            return false;
        }

        $controlerDir = 'controllers/'; //root folder for dir

        //in controller folder you are only allowed to create sub folder once
        //edit this  if you want to add extra sub folder
        if($this->checkIfDir($controlerDir.$url[0])){
            $dir = array_shift($url); // remove the first value of the $url and assigned to $dir
            $controlerDir .= $dir.'/';
            //print_r($url);
        }

        $file = $controlerDir.$url[0].".php"; //the file

        //check the index file if exists
        if(file_exists($file)){
            require $file;
        }else{
            //throw new Exception('Index file not found'); //throw error message
            require "controllers/error.php";
            $controller = new Error();
            return false;
        }


        $controller = new $url[0]; //instantiate the class

        if(isset($url[2])){ //check if the controller has argument
            $controller->$url[1]($url[2]); // call the controller then pass the argument
        }else{
            if(isset($url[1])){
                $controller->$url[1](); // call the controller
            }
        }
    }

    //check if file is a directory
    private function checkIfDir($name){
        if(is_dir($name)){
            return true;
        }
        return false;
    }
}