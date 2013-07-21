<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 On�rico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name indexController.php
     */
    session_start();
    class indexController extends Controller {
	// variable para el modelo Usuario
	private $Noticias;

	/**
	 * Constructor de la clase para instanciar los modelos
	 * @version 0.1
	 * @author Lucas M. sastre
	 * @access public
	 * @name __contruct
	 * Thu Dec 31 13:57:58 ART 2009
	 *
	 */
	function __construct() {
	    //llamo al consructor de Controller.php
	    parent::__construct();
	    $this->Noticias = new Noticias();
	    
	}
	public function index() {
            $where['ediciones.id'] = 5;
	    $data['paginador'] = $this->Utilidades->paginador($this->Noticias->listarNoticias($where),4);
	    $this->Vistas->show('index.html',$data);

	}	

    }
?>