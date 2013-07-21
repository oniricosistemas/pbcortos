<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.2
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 * @name SeoModel.php
 */
class Seo extends Modelo {
    protected $table = "core_seo";

    /**
     * Devuelve la lista de secciones para el seo
     * @version 0.2
     * @author Lucas M. sastre
     * @access public
     * @name listarSeccionesSeo
     *
     * @param  <array> $data
     * @return <string>
     *
     * Modificaciones
     */
    public function listarSeccionesSeo() {
        $sql = "SELECT *, cs.id as seo_id, cs.nombre as nombres FROM core_seo as cs
              LEFT JOIN core_lenguajes as cl ON
              cs.id_leng=cl.id
              GROUP BY cs.nombre
              ";

        return $sql;
    }

    /**
     * Crea una nueva seccion con el seo en su lenguaje
     * @version 0.2
     * @author Lucas M. Sastre
     * @access public
     * @name insertarSeccionSeo
     *
     * @param $data array
     * @return array
     *
     * Modificaciones
     */
    public function insertarSeccionSeo($data) {

        $insert['id_leng'] = "'".trim($data['id_leng'])."'";
        $insert['seccion'] = "'".trim($data['seccion'])."'";
        if(!empty($data['subaccion'])) {
            $insert['accion'] = "'".trim($data['subaccion'])."'";
        }
        $insert['nombre'] = "'".trim($data['nombres'])."'";
        $insert['titulo'] = "'".trim($data['titulo'])."'";
        $insert['descripcion'] = "'".trim($data['descripcion'])."'";
        $insert['keywords'] = "'".trim($data['keywords'])."'";

        $consulta=$this->db->InsertRow("core_seo", $insert);
        if(!$consulta) {
            $consulta = $this->db->Error();
        }
        else {
            $consulta = $this->db->GetLastInsertID();
        }

        return $consulta;
    }

    /**
     * Busca una seccion
     * @version 0.2
     * @author Lucas M. sastre
     * @access public
     * @name buscarSeccionSeo
     *
     * @param <array> $data
     * @return <array>
     *
     * Modificaciones
     */
    public function buscarSeccionSeo($data){
        $sql = "SELECT *, core_seo.id as seo_id,core_seo.nombre as nombres FROM core_seo
                LEFT JOIN core_lenguajes ON
                core_seo.id_leng=core_lenguajes.id
                WHERE 1 ";
        if(is_numeric($data)){
            $sql .= "AND core_seo.id='$data'";
        }
        else{
          $sql .= "AND core_seo.seccion='{$data['seccion']}'";  
        }
                
        if(!empty($data['subaccion']) && !is_numeric($data['subaccion'])){
            $sql .= " AND core_seo.accion='{$data['subaccion']}'";
        }        
        
        $consulta = $this->db->QueryArray($sql);
	
        if(!$consulta) {
            $consulta = $this->db->Error();
        }
        return $consulta;
    }

    /**
     * Edita una seccion seo
     * @version 0.2
     * @author Lucas M. sastre
     * @access public
     * @name editarSeccionesSeo
     *
     * @param  <array> $data
     * @return <string>
     *
     * Modificaciones
     */
    /*public function editarSeccionSeo($data){

        $update['seccion'] = "'".trim($data['seccion'])."'";
        if(!empty($data['subaccion'])){
            $update['accion'] = "'".trim($data['subaccion'])."'";
        }

        $update['nombre'] = "'".trim($data['nombres'])."'";
        $update['titulo'] = "'".trim($data['titulo'])."'";
        $update['descripcion'] = "'".trim($data['descripcion'])."'";
        $update['keywords'] = "'".trim($data['keywords'])."'";
        $filtro['id'] = $data['id'];
	//$filtro['id_leng'] = "'".trim($data['id_leng'])."'";

        $consulta=$this->db->UpdateRows("core_seo", $update, $filtro);
        if(!$consulta) {
            $consulta=$this->db->Error();
        }

        return $consulta;
    }*/

    /**
     * Devuelve los metas de una seccion
     * @version 0.2
     * @author Lucas M. sastre
     * @access public
     * @name metasSeo
     *
     * @param  <array> $data
     * @return <string>
     *
     * Modificaciones
     */
    public function metasSeo($data) {
        $sql = "SELECT * FROM core_seo
                INNER JOIN core_lenguajes ON
                core_seo.id_leng=core_lenguajes.id
                WHERE seccion='{$data['controlador']}' AND core_lenguajes.siglas='{$data['leng']}'";
        if(!empty($data['accion'])) {
            $sql .= " and accion='{$data['accion']}'";
        }

        $consulta = $this->db->QuerySingleRow($sql);
        if(!$consulta) {
            $consulta = $this->db->Error();
        }
        return $consulta;
    }
}