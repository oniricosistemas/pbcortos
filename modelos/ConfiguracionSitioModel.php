<?php
    /**
     * @package Punk Framework
     * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
     * @version 0.2
     * @author Lucas M. Sastre
     * @link http://www.oniricosistemas.com
     * @name UsuariosModel.php
     */

    class ConfiguracionSitio extends Modelo {

        protected $table = "core_configuracion";

        /**
	 * Devuelve la configuracion guardada en la base de datos
	 * @version 0.2
	 * @author Lucas M. sastre
	 * @access public
	 * @name listarConfiguracion

	 * @return array
	 */
	public function listarConfiguracion() {
	    $consulta=$this->db->QueryArray('SELECT * FROM core_configuracion');

	    return $consulta;
	}
	
    }
?>