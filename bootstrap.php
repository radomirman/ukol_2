<?php

require_once "vendor/autoload.php";

use Tracy\Debugger;
Debugger::enable();

$config = [
    'driver'=>'mysqli',
    'host'=>"localhost",
    'username'=>'root',
    'password'=>'toor',
    'database'=>'ukol'
];

$dibi = new Dibi\Connection($config);
if(!session_start()) session_start();
