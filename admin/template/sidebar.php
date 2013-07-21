<?php echo $breadCrumb;?>
<div id="sidebar">
	<ul class="sideNav">    
            <li><a href="index.php?controlador=configuracion"  <? if ($_REQUEST['controlador']=="configuracion"){echo 'id="active" ';}?>>Configuración del Sitio</a></li>
	    <li><a href="index.php?controlador=seo"  <? if ($_REQUEST['controlador']=="seo"){echo 'id="active" ';}?>>Opciones SEO</a></li>
            <li><a href="index.php?controlador=ediciones"  <? if ($_REQUEST['controlador']=="ediciones"){echo 'id="active" ';}?>>Ediciones</a></li>
            <li><a href="index.php?controlador=secciones"  <? if ($_REQUEST['controlador']=="secciones"){echo 'id="active" ';}?>>Secciones</a></li>
            <li><a href="index.php?controlador=noticias"  <? if ($_REQUEST['controlador']=="noticias"){echo 'id="active" ';}?>>Noticias</a></li>
            <li><a href="index.php?controlador=jurado"  <? if ($_REQUEST['controlador']=="jurado"){echo 'id="active" ';}?>>Jurado</a></li>
            <li><a href="index.php?controlador=staff"  <? if ($_REQUEST['controlador']=="staff"){echo 'id="active" ';}?>>Staff</a></li>
            <li><a href="index.php?controlador=categorias"  <? if ($_REQUEST['controlador']=="categorias"){echo 'id="active" ';}?>>Categorias Concurso</a></li>
            <li><a href="index.php?controlador=cortos"  <? if ($_REQUEST['controlador']=="cortos"){echo 'id="active" ';}?>>Cortos Seleccionados</a></li>
            <li><a href="index.php?controlador=prensa"  <? if ($_REQUEST['controlador']=="prensa"){echo 'id="active" ';}?>>Prensa</a></li>
            <li><a href="index.php?controlador=invitados"  <? if ($_REQUEST['controlador']=="invitados"){echo 'id="active" ';}?>>Invitados</a></li>
            <li><a href="index.php?controlador=peliculas"  <? if ($_REQUEST['controlador']=="peliculas"){echo 'id="active" ';}?>>Películas Invitadas</a></li>
            <li><a href="index.php?controlador=usuarios" <? if ($_REQUEST['controlador']=="usuarios"){echo 'id="active" ';}?>>Usuarios</a></li>
            <li><a href="index.php?controlador=logAccesos"  <? if ($_REQUEST['controlador']=="logAccesos"){echo 'id="active" ';}?>>Log de Accesos</a></li>
            <?php
            if($config->get('entorno') == 'dev'){?>
            <li><a href="index.php?controlador=errores" <? if ($_REQUEST['controlador']=="errrores"){echo 'id="active" ';}?>>Errores</a></li>
            <li><a href="index.php?controlador=log" <? if ($_REQUEST['controlador']=="log"){echo 'id="active" ';}?>>Log</a></li>
            <?php
            }
            ?>
	</ul>
<!-- // .sideNav -->
</div>
<div id="main">