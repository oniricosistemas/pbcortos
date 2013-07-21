<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     *
     */
    class logController extends Controller {
	private $Logg;

	/**
	 * Constructor de la clase
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name __construct
	 *
	 * Modificaciones
	 */
	function __construct() {
	    //llamo al contructor de Controller.php
	    parent::__construct();

	    //instancio el modelo
	    $this->Logg = new Log();
	}

	/**
	 * Index del controlador
	 * @version 0.1
	 * @author Lucas M. sastre
	 * @access public
	 * @name index
	 *
	 */
	public function index() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);

	    $data['datos'] = $this->Logg->listarLog();
	    $data['breadCrumb']=$this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    if($this->Session->get('mensaje')) {
		$data['mensaje'] = $this->Session->get('mensaje');
		$this->Session->del('mensaje');
	    }
	    $this->Vistas->show('index.php',$data);
	}

	/**
	 * detalle del log
	 * @version 0.1
	 * @author Lucas M. sastre
	 * @access public
	 * @name detalleLog
	 *
	 */
	public function verLog() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);

	    $data['datos'] = $this->Logg->verLog($_REQUEST['linea']);
	    $data['breadCrumb']=$this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $this->Vistas->show('editarLog.php',$data);
	}

	/**
	 * limpia el log
	 * @version 0.1
	 * @author Lucas M. sastre
	 * @access public
	 * @name limpiarLog
	 *
	 */
	public function limpiarLog() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);

	    $resultado = $this->Logg->vaciarLog();
	   
	    if($resultado==1) {
		$this->Mensajes->agregarMensaje(1,'El log se borro correctamente.','ok');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=log');
	    }
	    else {
		$this->Mensajes->agregarMensaje(1,'El Log no se borro correctamente.','error');
		$this->Mensajes->agregarMensaje(1,$resultado,'error');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=log');
	    }
	}


    }
?>
