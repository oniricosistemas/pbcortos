<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name indexController.php
     */
    session_start();
    class indexController extends Controller {
	
	/**
	 * Constructor de la clase para instanciar los modelos
	 * @version 0.1
	 * @author Lucas M. sastre
	 * @access public
	 * @name __contruct
	 *
	 */
	function __construct() {
	    //llamo al consructor de Controller.php
	    parent::__construct();
	    //creo una instancia de los modelos
            $this->modelo('noticias');
	}
	public function index() {
            $where['ediciones.id'] = " 6' OR ediciones.id = '7";
	    $data['paginador'] = $this->Utilidades->paginador($this->Noticias->listarNoticias($where),4);
	    $this->Vistas->show('index.php',$data);
	}
    }
?>