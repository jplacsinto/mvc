<?php
class View{
    function __construct(){

    }

    public function render($name){
        if(is_array($name)){
            foreach($name as $n){
                require 'views/'.$n.".php";
            }
        }else{
            require 'views/'.$name.".php";
        }
    }
}