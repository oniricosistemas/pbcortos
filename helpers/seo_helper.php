<?php
/**
 * seo
 *
 * devuelve los tag para el seo del sitio
 */
if ( ! function_exists('seo'))
{
    function seo($datos){
        $config = Config::singleton();
        $url = Url::singleton();
        $utilidades = Utilidades::singleton();
        include_once ($config->get('root') . $config->get('modelsFolder') . "ConfiguracionSitioModel.php");
        $conf = new ConfiguracionSitio();
        $debug = firePHP::getInstance();
        if(!empty($datos)){
            $p['titulo'] = $datos[0]['titulo_seo'];
            $p['descripcion'] = $datos[0]['descripcion_seo'];
            $p['keywords'] = $datos[0]['keywords'];
        }
        $conf->buscarPorPk(1);
        if(!empty($p)){
            $seo['titulo'] = $conf->titulo.' - '.$p['titulo'];
            
            if(!empty($p['descripcion'])){
                $seo['descripcion'] = $p['descripcion'];
            }
            else{
                $seo['descripcion'] = $conf->descripcion;
            }
            
            if(!empty($p['keywords'])){
                $seo['keywords'] = $p['keywords'];
            }
            else{
                $seo['keywords'] = $conf->keywords;
            }
        }
        else{
            $seo['titulo'] = $conf->titulo." - ".$url->segment(0);
            $seo['descripcion'] = $conf->descripcion;
            $seo['keywords'] = $conf->keywords;
        }
        if($config->get('multi')){
            $seo['lenguaje'] = $_SESSION['leng'];
        }
        else{
            $seo['lenguaje'] = $config->get('lenguaje');
        }

        return $seo;
    }
}

// ------------------------------------------------------------------------
/* fin del archivo seo_helper.php */
/* Ubicación: helpers/seo_helper.php */