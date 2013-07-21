<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name cortosController.php
     */

    class cortosController extends Controller {
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
            $this->modelo(array('cortos','ediciones','categorias'));


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
	    $paginador= $this->Utilidades->paginador($this->Cortos->listarCortos(),5);
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
	 * @name editarCortos
	 *
	 * Modificaciones
	 */
	public function editarCortos() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
            $data['ediciones'] = $this->Ediciones->listadoEdiciones();
            $data['categorias'] = $this->Categorias->listadoCategorias();
	    $data['datos'] = $this->Cortos->buscarPorPk($_REQUEST);
	    $this->Vistas->show('editarCortos.php',$data);
	}

	/**
	 * Muestra la vista para crear
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarCortos
	 *
	 * Modificaciones
	 */
	public function nuevoCortos() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
            $data['ediciones'] = $this->Ediciones->listadoEdiciones();
            $data['categorias'] = $this->Categorias->listadoCategorias();
	    $data['datos'] = $this->Cortos->buscarPorPk($_REQUEST['id']);
	    $this->Vistas->show('editarCortos.php',$data);
	}


	/**
	 * Edita un Lenguaje
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name guardarCortos
	 *
	 * Modificaciones
	 */
	public function guardarCortos() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
            $img = $_FILES['imagen'];
	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
                $data['ediciones'] = $this->Ediciones->listadoEdiciones();
                $data['categorias'] = $this->Categorias->listadoCategorias();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		$this->Vistas->show('editarCortos.php',$data);
	    }
	    else {
                $this->Cortos->setearCampos($_REQUEST);
		$resultado = $this->Cortos->guardar();
                $this->Debug->log($resultado);
		if($resultado) {
		    $this->Mensajes->agregarMensaje(1,'La Corto se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=cortos');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'La Corto no se pudo guardar correctamente.<br/>'.$this->Cortos->error,'error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
                    $data['ediciones'] = $this->Ediciones->listadoEdiciones();
                    $data['categorias'] = $this->Categorias->listadoCategorias();
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		    $this->Vistas->show('editarCortos.php',$data);
		}
	    }
	}

	/**
	 * borra un lengauje
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarCortos
	 *
	 * Modificaciones
	 */
	public function borrarCortos() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $resultado = $this->Cortos->borrarPorPk($_REQUEST['id']);
	    if($resultado==true) {
		$this->Mensajes->agregarMensaje(1,'La Corto se borro correctamente.','ok');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=cortos');
	    }
	    else {
		$this->Mensajes->agregarMensaje(1,'La Corto no se puedo borrar correctamente.<br/>'.$resultado,'error');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=cortos');
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
	    if(empty($data['titulo'])) {
		$mensaje .= 'El titulo del corto esta vacío<br/>';
	    }
            if(empty($data['director'])) {
		$mensaje .= 'El directo/res del corto esta vacío<br/>';
	    }
            if(empty($data['id_edicion'])) {
		$mensaje .= 'La edición del festival del corto esta vacía<br/>';
	    }
            if(empty($data['id_categorias'])) {
		$mensaje .= 'La categoria del corto esta vacío<br/>';
	    }
            if(empty($data['duracion'])) {
		$mensaje .= 'La duración del corto esta vacía<br/>';
	    }
            if(empty($data['lugar'])) {
		$mensaje .= 'El lugar del corto esta vacío<br/>';
	    }

	    return $mensaje;
	}
    }
?>