<?php
class View{
    function __construct(){
        //parent::__construct();
    }

    public function render($name, $data = null){
        if(!is_null($data)){
            foreach($data as $key=>$val){
                $$key = $val;
            }
        }

        if(is_array($name)){
            foreach($name as $n){
                require 'views/'.$n.".php";
            }
        }else{
            require 'views/'.$name.".php";
        }
    }
}