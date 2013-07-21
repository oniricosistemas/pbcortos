    <?
    if(!empty($mensaje)){
    echo $mensaje;
    }

    ?>
<h2><a href="index.php?controlador=staff&amp;accion=nuevaStaff" class="ajax" title="Crear Staff">Crear Nuevo Staff</a></h2>
    <h3>Listado de Staff</h3>
    <table cellpadding="0" cellspacing="0" summary="">
	<thead>
	    <tr>
		<th>#</th>
		<th>Nombre</th>
		<th>Cargo</th>
                <th>Edición</th>
		<th>&nbsp;</th>
	    </tr>
	</thead>
	<?
         $num_fila = 1;
	 $info = $paginador->superArray();
	 $i=1 + ( $info['porPagina'] * ( $info['numEstaPagina'] - 1 ) );
	 while ($staff=$paginador->fetchResultado()){
	    $j++;
	    if ($num_fila%2!=0){
		$class="class='odd'";
	    }
	    else{
		$class="";
	    }?>
	<tr <? echo $class;?>>
	    <td><? echo $staff['id'];?></td>
	    <td><? echo $staff['nombre'];?></td>
	    <td><? echo $staff['cargo'];?></td>
            <td><? echo $staff['edicion'];?></td>
	    <td class="action">
		<a class="edit ajax" href="index.php?controlador=staff&amp;accion=editarStaff&amp;id=<? echo $staff['id'];?>" title="Editar Staff">
									Editar
		</a>
		<a class="delete" href="index.php?controlador=staff&amp;accion=borrarStaff&amp;id=<? echo $staff['id'];?>" title="Borrar Staff">
									Borrar
		</a>
	    </td>
	</tr>
	<?php
	$num_fila++;
					}?>
	<tr><td colspan="5">&nbsp;</td></tr>
    </table>
    <? echo "<div id='navigation'>".$paginador->fetchNavegacion()."</div>";?>


