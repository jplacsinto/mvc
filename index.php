<?php


//config
include "config/config.php";

//use auto load
function __autoload($class){
    require LIBS.$class.'.php';
}

/*
include "libs/Bootstrap.php";
include "libs/Controller.php";
include "libs/Model.php";
include "libs/View.php";


//libraries
include "libs/Database.php";
include "libs/Session.php";
include "libs/Hash.php";
*/

$app = new Bootstrap();