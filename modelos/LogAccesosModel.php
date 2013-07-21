<?php
/**
 * @package Punk Framework
 * @copyright Copyright (C) 2010 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.2
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 * @name LogAccesosModel.php
 */

class LogAccesos extends Modelo {
    protected $table = "core_log_accesos";

    /**
     * Lista todos los logs del sistema
     *
     * @return <array>
     */
    public function listarLog($data) {
        $sql = "SELECT * FROM core_log_accesos WHERE 1";
        if(!empty($data['inicio']) && empty($data['fin'])) {
            $sql .= " AND DATE(fecha) ='{$data['inicio']}'";
        }
        if(!empty($data['fin']) && empty($data['inicio'])) {
            $sql .= " AND DATE(fecha) ='{$data['fin']}'";
        }
        if(!empty($data['fin']) && !empty($data['inicio'])) {
            $sql .= " AND fecha BETWEEN '{$data['inicio']}' AND '{$data['fin']}'";
        }
        if(!empty($data['nombre'])) {
            $sql .= " AND username like '{$data['nombre']}%'";
        }

        if(!empty($data['order'])) {
            switch ($data['order']) {
                case 'ip':
                    $order = 'ip';
                    break;

                case 'id':
                    $order = 'id';
                    break;

                case 'nombre':
                    $order = 'username';
                    break;

                case 'fecha':
                    $order = 'fecha';
                    break;
            }
        }
        else {
            $order = ' fecha';
        }
        if(!empty($data['orden'])) {
            $por = " {$data['orden']}";
        }
        else {
            $por = ' DESC';
        }
        $sql .= ' ORDER BY '.$order.$por;

        return $sql;
    }

}
?>