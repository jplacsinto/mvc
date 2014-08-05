<?php
class Index extends Controller{
    function __construct(){
        //echo 'im in admin index';
    }

    public function sample(){
        $this->loadModel('sample');
    }
}