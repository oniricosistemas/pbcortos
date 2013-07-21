<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name edicionesController.php
     */

    class edicionesController extends Controller {
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
            $this->modelo('ediciones');


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
	    $paginador= $this->Utilidades->paginador($this->Ediciones->listarEdiciones(),5);
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
	 * @name editarEdiciones
	 *
	 * Modificaciones
	 */
	public function editarEdiciones() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Ediciones->buscarPorPk($_REQUEST);
	    $this->Vistas->show('editarEdiciones.php',$data);
	}

	/**
	 * Muestra la vista para crear
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarEdiciones
	 *
	 * Modificaciones
	 */
	public function nuevoEdiciones() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Ediciones->buscarPorPk($_REQUEST['id']);
	    $this->Vistas->show('editarEdiciones.php',$data);
	}


	/**
	 * Edita un Lenguaje
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name guardarEdiciones
	 *
	 * Modificaciones
	 */
	public function guardarEdiciones() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
            $img = $_FILES['imagen'];
	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		$this->Vistas->show('editarEdiciones.php',$data);
	    }
	    else {
                if(!empty($img['name'])) {
		    // cargo las fotos de la animacion
		    $error=0;
		    $ok=0;
		    $image = $this->Imagen;
		    $nombreFoto = $this->Utilidades->validarNombreArchivo($img['name']);
		    $rutaFotoThumb = $this->Config->get('imagenes')."ediciones/edi_".$nombreFoto;
		    //creo el thumb
		    $image->load($img['tmp_name']);
		    $image->resize(299,133);
		    $image->save($rutaFotoThumb) ;
		    //valido si se creo el thumb y si existe
		    if(file_exists($rutaFotoThumb)) {
			$_REQUEST['imagen'] = str_replace($this->Config->get('imagenes'),'',$rutaFotoThumb);
                        $ok = 1;
                        $this->Debug->log('entro');
		    }
		    else {
			$this->Mensajes->agregarMensaje(1,'No se pudo guardar la siguiente imagen: '.$nombreFoto.' en el directorio:<br/> '.$rutaFoto.'','error');
			$error++;
		    }
		}
                if(empty($_REQUEST['imagen'])){
                    $_REQUEST['imagen'] = $_REQUEST['imgant'];
                }
                $this->Ediciones->setearCampos($_REQUEST);
		$resultado = $this->Ediciones->guardar();
                $this->Debug->log($resultado);
		if(is_numeric($resultado) || $resultado==true) {
		    $this->Mensajes->agregarMensaje(1,'La Edición se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=Ediciones');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'La Edición no se pudo guardar correctamente.<br/>'.$this->Ediciones->error,'error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		    $this->Vistas->show('editarEdiciones.php',$data);
		}
	    }
	}

	/**
	 * borra un lengauje
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarEdiciones
	 *
	 * Modificaciones
	 */
	public function borrarEdiciones() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $resultado = $this->Ediciones->borrarPorPk($_REQUEST['id']);
	    if($resultado==true) {
		$this->Mensajes->agregarMensaje(1,'La Edición se borro correctamente.','ok');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=ediciones');
	    }
	    else {
		$this->Mensajes->agregarMensaje(1,'La Edición no se puedo borrar correctamente.<br/>'.$resultado,'error');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=ediciones');
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
		$mensaje .= 'El titulo de la edición esta vacío<br/>';
	    }

	    return $mensaje;
	}
    }
?>