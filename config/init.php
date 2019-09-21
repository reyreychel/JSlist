<?php 
session_start();
function __autoload($class_name) {
  require_once 'includes/classes/'.$class_name . '.php';
}
require_once 'config.php';

?>