<?php
/**
* @package Punk Framework
* @copyright Copyright (C) 2011 Onírico Sistemas. Todos los derechos reservados.
* @version 0.3
* @author Lucas M. Sastre
* @link http://www.oniricosistemas.com
* @name error404Controller.php
 */
class error404Controller extends Controller {
    function index() {
        if($this->Session->get('mensaje')) {
            $data['mensaje'] = $this->Session->get('mensaje');
            $this->Session->del('mensaje');
        }
        elseif($this->Session->get('error')){
            $data['mensaje'] = $this->Session->get('error');
            $this->Session->del('error');
        }
        else {
            $data['mensaje'] = "<h2>La página a la que intenta ingresar no existe</h2>";
        }
        $this->Session->del('error');
        $this->Vistas->show('index.php',$data);
    }
}
?>