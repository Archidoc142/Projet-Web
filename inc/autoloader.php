<?php
function loadClass($className) {
    require_once './class/' . $className . '.php';
 }

 spl_autoload_register('loadClass');
 ?>