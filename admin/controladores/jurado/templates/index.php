<?
if (!empty($mensaje)) {
    echo $mensaje;
}
?>
<h2><a href="index.php?controlador=jurado&amp;accion=nuevaJurado" class="ajax" title="Crear Jurado">Crear Nuevo Jurado</a></h2>
    <h3>Listado de Jurados</h3>
    <table cellpadding="0" cellspacing="0" summary="">
	<thead>
	    <tr>
		<th>#</th>
		<th>Nombre</th>
                <th>Edición</th>
		<th>&nbsp;</th>
	    </tr>
	</thead>
	<?
         $num_fila = 1;
	 $info = $paginador->superArray();
	 $i=1 + ( $info['porPagina'] * ( $info['numEstaPagina'] - 1 ) );
	 while ($jurado=$paginador->fetchResultado()){
	    $j++;
	    if ($num_fila%2!=0){
		$class="class='odd'";
	    }
	    else{
		$class="";
	    }?>
	<tr <? echo $class;?>>
	    <td><? echo $jurado['id'];?></td>
	    <td><? echo $jurado['nombre'];?></td>
            <td><? echo $jurado['edicion'];?></td>
	    <td class="action">
		<a class="edit ajax" href="index.php?controlador=jurado&amp;accion=editarJurado&amp;id=<? echo $jurado['id'];?>" title="Editar Jurado">
        									Editar
                </a>
                <a class="delete" href="index.php?controlador=jurado&amp;accion=borrarJurado&amp;id=<? echo $jurado['id'];?>" title="Borrar Jurado">
									Borrar
                </a>
	    </td>
	</tr>
	<?php
	$num_fila++;
					}?>
	<tr><td colspan="4">&nbsp;</td></tr>
    </table>
    <? echo "<div id='navigation'>".$paginador->fetchNavegacion()."</div>";?>


