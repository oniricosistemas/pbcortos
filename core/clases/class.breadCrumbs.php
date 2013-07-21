<?php

/**
 * @package Punk Framework
 * @copyright Copyright (C) 2011 Onírico Sistemas. Todos los derechos reservados.
 * @version 0.3
 * @author Lucas M. Sastre
 * @link http://www.oniricosistemas.com
 *
 * @name class.breadCrumbs.php
 */
class breadCrumbs {

    /**
     * constructor
     *
     */
    function __construct() {
        
    }

    /**
     * devuelve la lista de breadcrumb
     *
     * @param string $ruta
     */
    public function listarBreadCrumb($ruta) {
        $config = Config::singleton();
        $url = Url::singleton();
        if(count($url->segmentArray())!=0){
            $link = $config->get('base');
            $salir = $config->get('base').'salir';
            $ruta['controlador'] = $url->segment(1);
            $ruta['accion'] = $url->segment(2);
        }
        else{
            $salir = 'index.php?controlador=index&amp;accion=salir';
            $link = 'index.php?controlador=';
        }
        

        if ((!$config->get('multi') || !$config->get('adminmulti'))) {
            $breadCrumb.='
		<ul id="mainNav">
		<li>
			<a href="index.php"';
            if ($ruta['controlador'] == '') {
                $breadCrumb.=' class="active ajax"';
            }
            $breadCrumb.='>
				Inicio
			</a>
		</li>
                <li>
			<a href="../index.php" title="Ver Sitio" target="_blank">
				Ver Sitio
			</a>
		</li>
                ';
            if ($ruta['controlador'] != '' && $ruta['controlador'] != 'index' && $ruta['accion'] == '') {
                $breadCrumb.='
        <li>
        	<a href="'. $link . $ruta['controlador'] . '" class="active ajax">
        		 ' . ucfirst(strtolower(preg_replace('/([A-Z])/', ' $1', $ruta['controlador']))) . '
        	</a>
        </li>';
            } elseif ($ruta['controlador'] != '' && $ruta['controlador'] != 'index') {
                $breadCrumb.='
        <li>
        	<a href="'. $link . $ruta['controlador'] . '" class="ajax">
        		' . ucfirst(strtolower(preg_replace('/([A-Z])/', ' $1', $ruta['controlador']))) . '
        	</a>
        </li>';
            }
            if ($ruta['accion'] != '' && $ruta['accion'] != 'index' && $ruta['accion'] != 'login') {
                $breadCrumb.='
        <li>
        	<a href="#" class="active ajax">
        		' . ucfirst(preg_replace('/([A-Z])/', ' $1', $ruta['accion'])) . '
        	</a>
        </li>';
            }

            $breadCrumb.='
        <li class="logout">
        	<a href="'.$salir.'" class="ajax">
        		Salir
        	</a>
        </li>
        </ul>
        <div id="containerHolder">
			<div id="container">';
        } else {
            $lenguaje = Language::singleton();
            $leng = $lenguaje->language_convert();
            $breadCrumb.='
		<ul id="mainNav">
		<li>
			<a href="index.php"';
            if ($ruta['controlador'] == '') {
                $breadCrumb.=' class="active ajax"';
            }
            $breadCrumb.='>
				'.$leng['inicio'].'
			</a>
		</li>
                <li>
			<a href="../index.php" title="'.$leng['ver_sitio'].'" target="_blank">
				'.$leng['ver_sitio'].'
			</a>
		</li>
                ';
            if ($ruta['controlador'] != '' && $ruta['controlador'] != 'index' && $ruta['accion'] == '') {
                $breadCrumb.='
        <li>
        	<a href="' . $link . $ruta['controlador'] . '" class="active ajax">
        		 ' . $leng[$ruta['controlador']] . '
        	</a>
        </li>';
            } elseif ($ruta['controlador'] != '' && $ruta['controlador'] != 'index') {
                $breadCrumb.='
        <li>
        	<a href="' . $link . $ruta['controlador'] . '" class="ajax">
        		' . $leng[$ruta['controlador']] . '
        	</a>
        </li>';
            }
            if ($ruta['accion'] != '' && $ruta['accion'] != 'index' && $ruta['accion'] != 'login') {
                $breadCrumb.='
        <li>
        	<a href="#" class="active ajax">
        		' . $leng[$ruta['accion']] . '
        	</a>
        </li>';
            }

            $breadCrumb.='
        <li class="logout">
        	<a href="'.$salir.'" class="ajax">
        		' . $leng['salir'] . '
        	</a>
        </li>
        </ul>
        <div id="containerHolder">
			<div id="container">';
        }

        return $breadCrumb;
    }

}

?>