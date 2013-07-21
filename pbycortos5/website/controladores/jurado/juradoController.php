<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 On�rico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name juradoController.php
     */
    session_start();
    class juradoController extends Controller {
	// variable para el modelo Usuario
	private $Jurado;
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
	    $this->Jurado = new Jurado();
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
	    $data['seccion'] = $this->Secciones->datosSeccion('jurado');
            $where['ediciones.id'] = 5;
	    $data['jurado'] = $this->Jurado->listadoJurado($where);
	    $this->Vistas->show('index.html',$data);

	}
	

    }
?>