<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name lenguajesController.php
     */

    class lenguajesController extends Controller {
	//variable para el modelo Lenguajes
	//private $Lenguajes;

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
	    //$this->Lenguajes = new Lenguajes();
            $this->modelo('lenguajes');


	}

	/**
	 * index del controlador
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name index
	 *
	 * Modificaciones
	 */
	public function index() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $paginador= $this->Utilidades->paginador($this->Lenguajes->listarLenguajes(),5);
	    $data['paginador'] = $paginador;
	    if($this->Session->get('mensaje')) {
		$data['mensaje'] = $this->Session->get('mensaje');
		$this->Session->del('mensaje');
	    }
	    $this->Vistas->show('index.php',$data);
	}

	/**
	 * Muestra la vista para editar
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarLenguajes
	 *
	 * Modificaciones
	 */
	public function editarLenguajes() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Lenguajes->buscarPorPk($_REQUEST);
	    $this->Vistas->show('editarLenguajes.php',$data);
	}

	/**
	 * Muestra la vista para crear
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarLenguajes
	 *
	 * Modificaciones
	 */
	public function nuevoLenguajes() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Lenguajes->buscarPorPk($_REQUEST);
	    $this->Vistas->show('editarLenguajes.php',$data);
	}


	/**
	 * Edita un Lenguaje
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name guardarLenguajes
	 *
	 * Modificaciones
	 */
	public function guardarLenguajes() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);

	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		$this->Vistas->show('editarLenguajes.php',$data);
	    }
	    else {
                $this->Lenguajes->setearCampos($_REQUEST);                
		$resultado = $this->Lenguajes->guardar();
                $this->Debug->log($resultado);
		if(is_numeric($resultado) || $resultado==true) {
		    $this->Mensajes->agregarMensaje(1,'El Lenguaje se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=Lenguajes');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'El Lenguaje no se pudo guardar correctamente.<br/>'.$this->Lenguajes->error,'error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		    $this->Vistas->show('editarLenguajes.php',$data);
		}
	    }
	}

	/**
	 * borra un lengauje
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarLenguajes
	 *
	 * Modificaciones
	 */
	public function borrarLenguajes() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $resultado = $this->Lenguajes->borrarPorPk($_REQUEST['id']);
	    if($resultado==true) {
		$this->Mensajes->agregarMensaje(1,'El Lenguaje se borro correctamente.','ok');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=lenguajes');
	    }
	    else {
		$this->Mensajes->agregarMensaje(1,'El Lenguaje no se puedo borrar correctamente.<br/>'.$resultado,'error');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=lenguajes');
	    }
	}

	/**
	 * Valida los datos enviados por el formulario
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access private
	 * @name validarDatosFormulario
	 *
	 * Modificaciones
	 */
	private function validarDatosFormulario($data) {
	    if(empty($data['idioma'])) {
		$mensaje .= 'El nombre del idioma esta vacío<br/>';
	    }

	    if(empty($data['siglas'])) {
		$mensaje .= 'Las siglas del idioma estan vacío<br/>';
	    }

	    return $mensaje;
	}
    }
?>