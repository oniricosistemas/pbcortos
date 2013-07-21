    <?
    if(!empty($mensaje)) {
        echo $mensaje;
    }
    ?>    
    <?php
    if($config->get('seo')){$debug->log("req".$leng);?>
    <h2><a class="ajax" href="index.php?controlador=seo&amp;accion=nuevoSeo" title="<?php echo $leng['nuevo_seo'];?>"><?php echo $leng['nuevo_seo'];?></a></h2>
    <?php
    }
    ?>
    <h3><?php echo $leng['lista_seo'];?></h3>
    <table cellpadding="0" cellspacing="0" summary="">
	<thead>
	    <tr>
		<th>#</th>
		<th><?php echo $leng['seccion'];?></th>
		<th><?php echo $leng['titulo'];?></th>
		<th><?php echo $leng['descripcion'];?></th>
		<th>Keywords</th>
		<th>&nbsp;</th>
	    </tr>
	</thead>
	<?
        $num_fila = 1;
        $info = $paginador->superArray();
        $i=1 + ( $info['porPagina'] * ( $info['numEstaPagina'] - 1 ) );
        while ($seo=$paginador->fetchResultado()){
	    $j++;
	    if ($num_fila%2!=0){
		$class="class='odd'";
	    }
	    else{
		$class="";
	    }?>
	<tr <? echo $class;?>>
	    <td><? echo $seo['seo_id'];?></td>
	    <td><? echo $seo['nombres'];?></td>
	    <td><? echo $utilidades->cortarTexto($seo['titulo'],50);?></td>
	    <td><? echo $utilidades->cortarTexto($seo['descripcion'],25);?></td>
	    <td><? echo $utilidades->cortarTexto($seo['keywords'],50);?></td>
	    <td class="action">
		<a class="edit ajax" href="index.php?controlador=seo&amp;accion=editarSeo&amp;seccion=<? echo $seo['seccion']; if(!empty($seo['accion'])){?>&amp;subaccion=<?php echo $seo['accion'];}?>" title="Edit">
                    Edit
		</a>
                <?php
                if($config->get('seo')){?>
		<a class="delete" href="index.php?controlador=seo&amp;accion=borrarSeo&amp;seccion=<? echo $seo['seccion'];?>" title="Borrar Usuario">
                    Borrar
		</a>
                <?php
                }
                ?>
	    </td>
	</tr>
	<?php
	$num_fila++;
	}?>
	<tr><td colspan="7">&nbsp;</td></tr>
    </table>
    <? echo "<div id='navigation'>".$paginador->fetchNavegacion()."</div>";?>

