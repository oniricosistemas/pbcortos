    <?
    if(!empty($mensaje)){
        echo $mensaje;
    }
    ?>
    <h2><a class="ajax" href="index.php?controlador=lenguajes&amp;accion=nuevoLenguajes" title="Crear Nuevo Idioma">Crear Nuevo Idioma</a></h2>
    <h3>Listado de Idiomas </h3>
    <table cellpadding="0" cellspacing="0" summary="">
	<thead>
	    <tr>
		<th>#</th>
		<th>Nombre</th>
		<th>Siglas</th>
		<th>&nbsp;</th>
	    </tr>
	</thead>
	<?
        $num_fila = 1;
        $info = $paginador->superArray();
        $i=1 + ( $info['porPagina'] * ( $info['numEstaPagina'] - 1 ) );
        while ($lenguajes=$paginador->fetchResultado()){
	    $j++;
	    if ($num_fila%2!=0){
		$class="class='odd'";
	    }
	    else{
		$class="";
	    }?>
	<tr <? echo $class;?>>
	    <td><? echo $lenguajes['id'];?></td>
	    <td><? echo $lenguajes['idioma'];?></td>
	    <td><? echo $lenguajes['siglas'];?></td>
	    <td class="action">
		<a class="edit ajax" onclick="envioAjax('index.php?controlador=lenguajes&amp;accion=editarLenguajes&amp;id=<? echo $lenguajes['id'];?>');return false;" href="index.php?controlador=lenguajes" title="Editar Idioma">
        									Editar
		</a>
		<a class="delete" href="index.php?controlador=lenguajes&amp;accion=borrarLenguajes&amp;id=<? echo $lenguajes['id'];?>" title="Borrar Idioma">
									Borrar
		</a>
	    </td>
	</tr>
	<?php
	$num_fila++;
	}?>
	<tr><td colspan="7">&nbsp;</td></tr>
    </table>
    <? echo "<div id='navigation'>".$paginador->fetchNavegacion()."</div>";?>

