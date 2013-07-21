<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2011 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.3
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 * @name usuariosController.php
 */

class usuariosController extends Controller {

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
        $this->modelo(array('Usuarios','Permisos'));
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
        $paginador= $this->Utilidades->paginador($this->Usuarios->listarUsuarios($_REQUEST),5);
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
     * @name editarUsuarios
     *
     * Modificaciones
     */
    public function nuevoUsuarios() {
        $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
        $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
        $data['permisos'] = $this->PermisosUsuarios->listarPermisos($this->Config->get('root').$this->Config->get('adminControllerFolder'));
        $this->Vistas->show('editarUsuarios.php',$data);
    }

    /**
     * Muestra la vista para editar
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @name editarUsuarios
     *
     * Modificaciones
     */
    public function editarUsuarios() {
        $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
        $data['permisos'] = $this->PermisosUsuarios->listarPermisos($this->Config->get('root').$this->Config->get('adminControllerFolder'));
        $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
        $data['datos'] = $this->Usuarios->buscarUsuarios($_REQUEST);
        $datos['id_usuario'] = $data['datos']->id;
        $data['permisoUsuario'] = $this->Permisos->listadoPermisos($datos);
        $this->Vistas->show('editarUsuarios.php',$data);
    }


    /**
     * Edita Usuario
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @name guardarUsuarios
     *
     * Modificaciones
     */
    public function guardarUsuarios() {
        $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
        $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
        $mensaje = $this->validarDatosFormulario($_REQUEST);
        if(!empty($mensaje)) {
            $this->Mensajes->agregarMensaje(1,$mensaje,'error');
            $data['mensaje'] = $this->Mensajes->mostrarMensaje();
            $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
            $data['permisos'] = $this->PermisosUsuarios->listarPermisos($this->Config->get('root').$this->Config->get('adminControllerFolder'));
            $this->Vistas->show('editarUsuarios.php',$data);
        }
        else {
            if($_REQUEST['id']=='') {
                $_REQUEST['password'] = md5($_REQUEST['password']);
            }
            else {
                $_REQUEST['password'] = $_REQUEST['clave'];
            }
            $this->Usuarios->setearCampos($_REQUEST);
            $resultado = $this->Usuarios->guardar();

            if($resultado) {
                if(!empty($_REQUEST['controladores'])) {
                    $this->Permisos->permisos = serialize($_REQUEST['controladores']);
                    $this->Permisos->id_usuario = $this->Usuarios->ultimoId;
                    $this->Permisos->id = $_REQUEST['permisos_id'];
                    $permisos = $this->Permisos->guardar();
                }
                else {
                    $permisos = true;
                }
                if($permisos) {
                    $this->Mensajes->agregarMensaje(1,'El Usuario se guardo correctamente.','ok');
                    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
                    $this->Utilidades->redirect('index.php?controlador=Usuarios');
                }
                else {
                    $this->Mensajes->agregarMensaje(1,'El Usuario se guardo correctamente. Pero no los permisos','ok');
                    $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
                    $this->Utilidades->redirect('index.php?controlador=Usuarios');
                }
            }
            else {
                $this->Mensajes->agregarMensaje(1,'El Usuario no se pudo guardar correctamente.','error');
                $this->Mensajes->agregarMensaje(1,$resultado,'error');
                $data['mensaje'] = $this->Mensajes->mostrarMensaje();
                $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
                $data['permisos'] = $this->PermisosUsuarios->listarPermisos($this->Config->get('root').$this->Config->get('adminControllerFolder'));
                $this->Vistas->show('editarUsuarios.php',$data);
            }
        }
    }


    /**
     * Edita Usuario
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @name guardarUsuarios
     *
     * Modificaciones
     */
    /*public function guardarUsuarios() {
	    $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
	    $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);

	    $mensaje = $this->validarDatosFormulario($_REQUEST);
	    if(!empty($mensaje)) {
		$this->Mensajes->agregarMensaje(1,$mensaje,'error');
		$data['mensaje'] = $this->Mensajes->mostrarMensaje();
		$data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		$data['permisos'] = $this->PermisosUsuarios->listarPermisos($this->Config->get('root').$this->Config->get('adminControllerFolder'));
		$this->Vistas->show('editarUsuarios.php',$data);
	    }
	    else {
		if(!empty($_REQUEST['password']) && $_REQUEST['password']==$_REQUEST['clave']) {
		    $_REQUEST['password'] = $_REQUEST['clave'];
		}
		elseif(!empty($_REQUEST['password'])) {
		    $_REQUEST['password'] = md5($_REQUEST['password']);
		}
		$resultado = $this->Usuarios->editarUsuarios($_REQUEST);
		$_REQUEST['permisos'] = serialize($_REQUEST['controladores']);
		if($this->Permisos->validarExisteUsuario($_REQUEST)) {
		    $permisos = $this->Permisos->editarPermisos($_REQUEST);
		}
		else {
		    $permisos = $this->Permisos->nuevoPermisos($_REQUEST);
		}
		if($resultado==true) {
		    if($permisos==true) {
			$this->Mensajes->agregarMensaje(1,'El Usuario se guardo correctamente.','ok');
			$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
			$this->Utilidades->redirect('index.php?controlador=Usuarios');
		    }
		    else {
			$this->Mensajes->agregarMensaje(1,'El Usuario se guardo correctamente. Pero los permisos no.','ok');
			$this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
			$this->Utilidades->redirect('index.php?controlador=Usuarios');
		    }
		}
		else {
		    $this->Mensajes->agregarMensaje(1,'El Usuario no se pudo guardar correctamente.','error');
		    $this->Mensajes->agregarMensaje(1,$resultado,'error');
		    $data['mensaje'] = $this->Mensajes->mostrarMensaje();
		    $data['datos'] = $this->Utilidades->arrayObjeto($_REQUEST);
		    $data['permisos'] = $this->PermisosUsuarios->listarPermisos($this->Config->get('root').$this->Config->get('adminControllerFolder'));
		    $this->Vistas->show('editarUsuarios.php',$data);
		}
	    }
	}*/

    /**
     * borra un usuario
     * @version 0.1
     * @author Lucas M. Sastre
     * @access public
     * @name borrarNoticia
     *
     * Modificaciones
     */
    public function borrarUsuarios() {
        $this->PermisosUsuarios->validarPermisos($this->Session->get('user_id'),__METHOD__);
        $data['breadCrumb'] = $this->BreadCrumb->listarBreadCrumb($_REQUEST);
        $resultado = $this->Usuarios->borrarPorPk($_REQUEST['id']);
        $data['id_usuario'] = $_REQUEST['id'];
        $this->Permisos->borrarPermisos($data);
        if($resultado==true) {
            $this->Mensajes->agregarMensaje(1,'El Usuario se borro correctamente.','ok');
            $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
            $this->Utilidades->redirect('index.php?controlador=usuarios');
        }
        else {
            $this->Mensajes->agregarMensaje(1,'El Usuario no se puedo borrar correctamente.','error');
            $this->Session->set('mensaje',$this->Mensajes->mostrarMensaje());
            $this->Utilidades->redirect('index.php?controlador=usuarios');
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

        if(empty($data['username'])) {
            $mensaje .= 'El nombre de Usuario esta vacío<br/>';
        }

        if(!empty($data['email']) && !$this->Utilidades->validar_mail($data['email'])) {
            $mensaje .= 'El email esta vacío o es invalido<br/>';
        }
        if(empty($data['estado'])) {
            $mensaje .= 'No ha seleccionado un estado para el usuario<br/>';
        }


        return $mensaje;
    }
}


?>