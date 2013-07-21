<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2011 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.3
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name peliculasController.php
     */

    class peliculasController extends Controller {
        
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
            $this->modelo(array('peliculas','ediciones'));


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
	    $paginador= $this->Utilidades->paginador($this->Peliculas->listarPeliculas(),5);
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
	 * @name editarPeliculas
	 *
	 * Modificaciones
	 */
	public function editarPeliculas() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Peliculas->buscarPorPk($_REQUEST['id']);
            $data['ediciones'] = $this->Ediciones->listadoEdiciones();
	    $this->Vistas->show('editarPeliculas.php',$data);
	}
	

	/**
	 * Muestra la vista para crear
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name editarPeliculas
	 *
	 * Modificaciones
	 */
	public function nuevoPeliculas() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $data['datos'] = $this->Peliculas->buscarPorPk($_REQUEST);
            $data['ediciones'] = $this->Ediciones->listadoEdiciones();
	    $this->Vistas->show('editarPeliculas.php',$data);
	}


	/**
	 * guarda una pelicula
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name guardarPeliculas
	 *
	 * Modificaciones
	 */
	public function guardarPeliculas() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
            $img = $_FILES['imagen'];
	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
                $data['ediciones'] = $this->Ediciones->listadoEdiciones();
		$this->Vistas->show('editarPeliculas.php',$data);
	    }
	    else {
                if(!empty($img['name'])) {
		    // cargo las fotos de la animacion
		    $error=0;
		    $ok=0;
		    $image = $this->Imagen;
		    $nombreFoto = $this->Utilidades->validarNombreArchivo($img['name']);
		    $rutaFotoThumb = $this->Config->get('imagenes')."peliculas/peli_".$nombreFoto;
		    //creo el thumb
		    $image->load($img['tmp_name']);
		    $image->resize(132,187);
		    $image->save($rutaFotoThumb) ;
		    //valido si se creo el thumb y si existe
		    if(file_exists($rutaFotoThumb)) {
			$_REQUEST['afiche'] = str_replace($this->Config->get('imagenes'),'',$rutaFotoThumb);
                        $ok = 1;
                        $this->Debug->log('entro');
		    }
		    else {
			$this->Mensajes->agregarMensaje(1,'No se pudo guardar la siguiente imagen: '.$nombreFoto.' en el directorio:<br/> '.$rutaFoto.'','error');
			$error++;
		    }
		}
                $this->Debug->info($_REQUEST['imagen']);
                if(empty($_REQUEST['afiche'])){
                    $_REQUEST['afiche'] = $_REQUEST['imgant'];
                }
                
                $this->Peliculas->setearCampos($_REQUEST);
		$resultado = $this->Peliculas->guardar();
		if($resultado) {
		    $this->Mensajes->agregarMensaje(1,'La pelicula se guardo correctamente.','ok');
		    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		    $this->Utilidades->redirect('index.php?controlador=peliculas');
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'La pelicula no se pudo guardar correctamente.<br/>'.$this->Peliculas->error,'error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
                    $data['ediciones'] = $this->Ediciones->listadoEdiciones();
		    $this->Vistas->show('editarPeliculas.php',$data);
		}
	    }
	}

	/**
	 * borra una pelicula
	 * @version 0.1
	 * @author Lucas M. Sastre
	 * @access public
	 * @name borrarPeliculas
	 *
	 * Modificaciones
	 */
	public function borrarPeliculas() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
	    $resultado = $this->Peliculas->borrarPorPk($_REQUEST['id']);
	    if($resultado==true) {
		$this->Mensajes->agregarMensaje(1,'La pelicula se borro correctamente.','ok');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=peliculas');
	    }
	    else {
		$this->Mensajes->agregarMensaje(1,'La pelicula no se puedo borrar correctamente.<br/>'.$resultado,'error');
		$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
		$this->Utilidades->redirect('index.php?controlador=peliculas');
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
		$mensaje .= 'El titulo de la pelicula esta vacío<br/>';
	    }

	    if(empty($data['intro'])) {
		$mensaje .= 'No ha ingresado una texto para la pelicula<br/>';
	    }

            if(empty($data['id_edicion'])) {
		$mensaje .= 'No ha ingresado una edición para la pelicula<br/>';
	    }
            
            
	    return $mensaje;
	}
    }
?>