<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name staffController.php
     */
    session_start();
    class staffController extends Controller {
	// variable para el modelo Usuario
	private $Staff;
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
	    $this->Staff = new Staff();
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
	    $data['seccion'] = $this->Secciones->datosSeccion('staff');
	    $data['staff'] = $this->Staff->listadoStaff();
	    $this->Vistas->show('index.html',$data);

	}
	

    }
?>