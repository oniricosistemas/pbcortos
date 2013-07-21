<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name noticiasController.php
     */
    session_start();
    class noticiasController extends Controller {
	
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
            $data['datos'] = $this->Noticias->buscarNoticia('',$this->Url->segment(1));
	    $this->Vistas->show('index.php',$data);
	}
    }
?>