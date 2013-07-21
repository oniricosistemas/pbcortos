<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2011 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.3
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name seccionesController.php
     */

    class seccionesController extends Controller {
        
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
            $this->modelo(array('secciones','ediciones'));


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
	    $paginador = $this->Utilidades->paginador($this->Secciones->listarSecciones(),5);
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
	 * @name editarSecciones
	 *
	 * Modificaciones
	 */
	public function editarSecciones() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Secciones->buscarPorPk($_REQUEST['id']);
            $data['ediciones'] = $this->Ediciones->listadoEdiciones();
	    $this->Vistas->show('editarSecciones.php',$data);
	}
	

	/**
	 * Muestra la vista para crear
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarSecciones
	 *
	 * Modificaciones
	 */
	public function nuevoSecciones() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Secciones->buscarPorPk($_REQUEST);
            $data['ediciones'] = $this->Ediciones->listadoEdiciones();
	    $this->Vistas->show('editarSecciones.php',$data);
	}


	/**
	 * guarda una sección
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name guardarSecciones
	 *
	 * Modificaciones
	 */
	public function guardarSecciones() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);

	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
                $data['ediciones'] = $this->Ediciones->listadoEdiciones();
		$this->Vistas->show('editarSecciones.php',$data);
	    }
	    else {
                $_REQUEST['titulo_seo'] = $_REQUEST['titulo'];
                $_REQUEST['url_amigable'] = strtolower($this->Utilidades->validarNombreArchivo($_REQUEST['titulo']));
                $this->Secciones->setearCampos($_REQUEST);
		$resultado = $this->Secciones->guardar();
                $this->Debug->log($resultado);
		if($resultado) {
		    $this->Mensajes->agregarMensaje(1,'La sección se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=secciones');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'La sección no se pudo guardar correctamente.<br/>'.$this->Secciones->error,'error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
                    $data['ediciones'] = $this->Ediciones->listadoEdiciones();
		    $this->Vistas->show('editarSecciones.php',$data);
		}
	    }
	}

	/**
	 * borra una sección
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarSecciones
	 *
	 * Modificaciones
	 */
	public function borrarSecciones() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $resultado = $this->Secciones->borrarPorPk($_REQUEST['id']);
	    if($resultado==true) {
		$this->Mensajes->agregarMensaje(1,'La sección se borro correctamente.','ok');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=secciones');
	    }
	    else {
		$this->Mensajes->agregarMensaje(1,'La sección no se puedo borrar correctamente.<br/>'.$resultado,'error');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=secciones');
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
		$mensaje .= 'El titulo de la sección esta vacío<br/>';
	    }

	    if(empty($data['texto'])) {
		$mensaje .= 'No ha ingresado una texto para la sección<br/>';
	    }
            if(empty($data['id_edicion'])) {
		$mensaje .= 'No ha ingresado una edición para la sección<br/>';
	    }
            
	    return $mensaje;
	}
    }
?>