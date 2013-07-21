<?
    if(!empty($mensaje)){
    echo $mensaje;
    }
    ?>
<h2><a href="index.php?controlador=invitados&amp;accion=nuevaInvitados" class="ajax" title="Crear Invitados">Crear Nuevo Invitados</a></h2>
    <h3>Listado de Invitados Especiales</h3>
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
	 while ($invitados=$paginador->fetchResultado()){
	    $j++;
	    if ($num_fila%2!=0){
		$class="class='odd'";
	    }
	    else{
		$class="";
	    }?>
	<tr <? echo $class;?>>
	    <td><? echo $invitados['id'];?></td>
	    <td><? echo $invitados['nombre'];?></td>
            <td><? echo $invitados['edicion'];?></td>
	    <td class="action">
		<a class="edit ajax" href="index.php?controlador=invitados&amp;accion=editarInvitados&amp;id=<? echo $invitados['id'];?>" title="Editar Invitados">
									Editar
		</a>
		<a class="delete" href="index.php?controlador=invitados&amp;accion=borrarInvitados&amp;id=<? echo $invitados['id'];?>" title="Borrar Invitados">
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


