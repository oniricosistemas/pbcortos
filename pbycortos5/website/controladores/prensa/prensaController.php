<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name prensaController.php
     */
    session_start();
    class prensaController extends Controller {
	// variable para el modelo Usuario
	private $Prensa;
	private $Secciones;

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
	    $this->Prensa = new Prensa();
	    $this->Secciones = new Secciones();
	    
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
	    $data['seccion'] = $this->Secciones->datosSeccion('prensa');
	    $data['prensa'] = $this->Prensa->listadoPrensa();
	    $this->Vistas->show('index.html',$data);

	}
	

    }
?>