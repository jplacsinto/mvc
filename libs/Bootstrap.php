<?php
class Bootstrap{
    function __construct(){

        $url = isset($_GET['url'])?$_GET['url']:null; //get the url
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = rtrim($url, '/'); //remove slashes
        $url = explode('/', $url);// explode by slashes


        $controlerDir = 'controllers/'; //root folder for dir


        //this will check if the url is a directory, if it is $url array will be shifted
        $thisUrl = null;
        $dirUrl = null;
        $numShift = 0;
        for($x=0; $x<count($url); $x++){
            $thisUrl .= $url[$x].'/';
            if(is_dir($controlerDir.$thisUrl)){
                $dirUrl .= $url[$x].'/';
                $numShift++;
            }else{
                continue;
            }
        }

        $controlerDir .= $dirUrl;

        for($x=0; $x<$numShift; $x++){
            array_shift($url);
        }

        if(empty($url)){
            $url = array('index');
        }

        $file = $controlerDir.$url[0].".php"; //the file
        //print_r($url);

        //check the index file if exists
        if(file_exists($file)){
            require $file;
        }else{
            //load error message
            require "controllers/error.php";
            $controller = new Error();
            $controller->index();
            return false;
        }


        //print_r($url);
        $controller = new $url[0]; //instantiate the class
        //load model if exist
        $controller->loadMOdel($url[0].'_model');

        if(isset($url[1])){ //check if the controller has argument
            if(method_exists($controller, $url[1])){
                $numArg = $this->reflection($controller, $url[1]);
                if($numArg>0){
                    $dataParams = array();
                    for($x=1; $x<=$numArg; $x++){
                        $dataParams[] = (!empty($url[$x+1]))?$url[$x+1]:null;
                    }
                    //call the method and assign array as param
                    call_user_func_array([$controller, $url[1]], $dataParams);
                }else{
                    $controller->$url[1]();
                }
            }else{
                //load error message
                require "controllers/error.php";
                $controller = new Error();
                $controller->index();
                return false;
            }
        }else{
            if(method_exists($controller, 'index')){
                $controller->index(); // call the controller
            }
        }
    }
    private function reflection($controller, $method){
        //count all parameters inside the method then insert to array
        $refl = new ReflectionMethod($controller, $method);
        return $refl->getNumberOfParameters();
    }
}