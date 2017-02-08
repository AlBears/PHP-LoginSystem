<?php

spl_autoload_register('myAutoloader');

function myAutoloader($className)

{
  require dirname(dirname(__FILE__)) . '/classes/' . $className . '.class.php';
}





 
