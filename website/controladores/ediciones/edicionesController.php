<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 On�rico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name edicionesController.php
     */
    session_start();
    class edicionesController extends Controller {
	// variable para el modelo Usuario
	private $Ediciones;

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
	    $this->Ediciones = new Ediciones();
	    
	}

	/**
	 * Constructor de la clase para instanciar los modelos
	 * @version 0.1
	 * @author Lucas M. sastre
	 * @access public
	 * @name index
	 *
	 */
	public function index() {
	    $where['ediciones.id'] = '< 7';
	    $data['ediciones'] = $this->Ediciones->listadoEdiciones($where);
	    $this->Vistas->show('index.php',$data);

	}
	

    }
?>