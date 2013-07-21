    <?php
    if(!empty($mensaje)){
        echo $mensaje;
    }

    ?>
<h2><a href="index.php?controlador=prensa&amp;accion=nuevaPrensa" class="ajax" title="Crear Prensa">Crear Nueva Prensa</a></h2>
    <h3>Listado de Prensa</h3>
    <table cellpadding="0" cellspacing="0" summary="">
	<thead>
	    <tr>
		<th>#</th>
		<th>Fecha</th>
		<th>&nbsp;</th>
	    </tr>
	</thead>
	<?
         $num_fila = 1;
	 $info = $paginador->superArray();
	 $i=1 + ( $info['porPagina'] * ( $info['numEstaPagina'] - 1 ) );
	 while ($prensa=$paginador->fetchResultado()){
	    $j++;
	    if ($num_fila%2!=0){
		$class="class='odd'";
	    }
	    else{
		$class="";
	    }?>
	<tr <? echo $class;?>>
	    <td><? echo $prensa['id'];?></td>
	    <td><? echo $utilidades->cortarTexto($prensa['texto'],100,array('ending'=>' ...','exact'=>false,'html'=>true));?></td>
	    <td class="action">
		<a class="edit ajax" href="index.php?controlador=prensa&amp;accion=editarPrensa&amp;id=<? echo $prensa['id'];?>" title="Editar Prensa">
									Editar
		</a>
		<a class="delete" onclick="if (ask()) window.location='index.php?controlador=prensa&amp;accion=borrarPrensa&amp;id=<? echo $prensa['id'];?>'" href="#" title="Borrar Prensa">
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


