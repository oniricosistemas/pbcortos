<?php
/**
* @package Punk Framework
* @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
* @version 0.2
* @author Lucas M. Sastre
* @link http://www.oniricosistemas.com
* @name index.php
*/


    ob_start();
    require '../core/clases/FrontController.php';

    $router = new Router($_SERVER['PHP_SELF']);
    $router->loader();
    $router->route();
    ob_flush();
?>