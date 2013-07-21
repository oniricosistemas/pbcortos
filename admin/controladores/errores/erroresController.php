<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     *
     * @name erroresController.php
     */
    class erroresController extends Controller {
	private $Errores;

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
	    $this->Errores = new ErroresSistema();
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

	    $data['paginador'] = $this->Utilidades->paginador($this->Errores->listarErrores($_REQUEST),10);
	    $data['breadCrumb']=$this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    if($this->Session->get('mensaje')) {
		$data['mensaje'] = $this->Session->get('mensaje');
		$this->Session->del('mensaje');
	    }
	    $this->Vistas->show('index.php',$data);
	}

	/**
	 * ver el log
	 * @version 0.1
	 * @author Lucas M. sastre
	 * @access public
	 * @name limpiarErrores
	 *
	 */
	public function verError(){
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb']=$this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Errores->buscarErrores($_REQUEST);
	    $this->Vistas->show('editarError.php',$data);
	}
	
	/**
	 * limpia el log
	 * @version 0.1
	 * @author Lucas M. sastre
	 * @access public
	 * @name limpiarErrores
	 *
	 */
	public function limpiarErrores() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $resultado = $this->Errores->vaciarErrores();
	    if($resultado==1) {
		$this->Mensajes->agregarMensaje(1,'El log se limpio correctamente.','ok');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=errores');
	    }
	    else {
		$this->Mensajes->agregarMensaje(1,'El log no se limpio correctamente.','error');
		$this->Mensajes->agregarMensaje(1,$resultado,'error');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=errores');
	    }
	}


    }
?>
