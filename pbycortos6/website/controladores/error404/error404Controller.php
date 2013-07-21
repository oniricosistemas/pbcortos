<?php
/**
* @package Punk Framework
* @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
* @version 0.2
* @author Lucas M. Sastre
* @link http://www.oniricosistemas.com
* @name error404Controller.php
 */
class error404Controller extends Controller {
    function index() {     
        $data['mensaje'] = "La página a la que intenta ingresar no existe";
        $this->Vistas->show('index.html',$data);
    }
}
?>