<?php
class View{
    function __construct(){
        //parent::__construct();
    }

    public function render($name, $data = null, $wrap = true){
        $header = 'views/header.php';
        $footer = 'views/footer.php';
        if(!is_null($data)){
            foreach($data as $key=>$val){
                $$key = $val;
            }
        }

        if($wrap && file_exists($header)) require($header);

        if(is_array($name)){
            foreach($name as $n){
                require 'views/'.$n.".php";
            }
        }else{
            require 'views/'.$name.".php";
        }

        if($wrap && file_exists($footer)) require($footer);
    }
}