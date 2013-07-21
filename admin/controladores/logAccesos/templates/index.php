    <?
    if(!empty($mensaje)) {
        echo $mensaje;
    }
    ?>
    <?php
    if ($paginador->numTotalRegistros()!=0){?>
    <h2><a class="ajax" href="index.php?controlador=logAccesos&amp;accion=limpiarLog" title="Limpiar el log de accesos">Limpiar el log de accesos</a></h2>
    <?php
    }
    ?>  
    <h3>Listado de Accesos </h3>
    <div class="portlet">
	<div class="portlet-header">Filtros de Búsqueda</div>
	<div class="portlet-content">
	    <form action="index.php?controlador=logAccesos&amp;accion=index" method="post">
		<div class="filtro">
		    <label>Nombre Usuario: </label><input type="text" class="text-short" name="nombre" value=""/>
		</div>
		<div class="filtro">
		    <label>Fecha entre : </label><input type="text" class="text-short" readonly="readonly" id="datepicker" name="inicio" value=""/> Y <input type="text" class="text-short" readonly="readonly" id="datepicker2" name="fin" value=""/>
		</div>

		<div class="filtro">
		    <label>Ordenar por: </label>
		    <select name="order">
			<option value="">&nbsp;</option>
			<option value="id">ID</option>
			<option value="fecha">Fecha</option>
			<option value="ip">IP</option>
			<option value="nombre">Username</option>
		    </select>
		</div>
		<div class="clear"></div>
		<div class="filtro">
		    <button type="submit"> <img src="<?php echo $config->get('urlRoot').$config->get('adminViewsFolder').'images/';?>search.png" alt="buscar"/></button>
		</div>
	    </form>
	</div>
    </div>
    <table cellpadding="0" cellspacing="0" summary="">
	<thead>
	    <tr>
		<?php
		$img = $config->get('urlRoot').'/'.$config->get('adminViewsFolder').'images/';
		$link = $utilidades->linkOrdenar('index.php?controlador=logAccesos&amp;accion=index&amp;order=id',$_REQUEST,'id');		
		?>
		<th><a href="<?php echo $link['url'];?>" class="ajax" title="<?php echo ucfirst($link['por']);?>"><img src="<?php if($link['seleccion']=='id'){echo $img.$link['icon'];}else{echo $img.'upDown';}?>.png" alt="<?php if($link['seleccion']=='id'){echo ucfirst($link['por']);}else{echo '';}?>"/></a> #</th>
		<?php
		$link = $utilidades->linkOrdenar('index.php?controlador=logAccesos&amp;accion=index&amp;order=fecha',$_REQUEST,'fecha');		
		?>
		<th><a href="<?php echo $link['url'];?>" class="ajax" title="<?php echo ucfirst($link['por']);?>"><img src="<?php if($link['seleccion']=='fecha'){echo $img.$link['icon'];}else{echo $img.'upDown';}?>.png" alt="<?php if($link['seleccion']=='fecha'){echo ucfirst($link['por']);}else{echo '';}?>"/></a> Fecha</th>
		<?php
		$link = $utilidades->linkOrdenar('index.php?controlador=logAcceso&amp;accion=index&amp;order=ip',$_REQUEST,'ip');		
		?>
		<th><a href="<?php echo $link['url'];?>" class="ajax" title="<?php echo ucfirst($link['por']);?>"><img src="<?php if($link['seleccion']=='ip'){echo $img.$link['icon'];}else{echo $img.'upDown';}?>.png" alt="<?php if($link['seleccion']=='ip'){echo ucfirst($link['por']);}else{echo '';}?>"/></a> IP</th>
		<?php
		$link = $utilidades->linkOrdenar('index.php?controlador=logAccesos&amp;accion=index&amp;order=nombre',$_REQUEST,'nombre');		
		?>
		<th><a href="<?php echo $link['url'];?>" class="ajax" title="<?php echo ucfirst($link['por']);?>"><img src="<?php if($link['seleccion']=='nombre'){echo $img.$link['icon'];}else{echo $img.'upDown';}?>.png" alt="<?php if($link['seleccion']=='nombre'){echo ucfirst($link['por']);}else{echo '';}?>"/></a> Usuario</th>
	    </tr>
	</thead>
	<?
        $num_fila = 1;
        $info = $paginador->superArray();
        $i=1 + ( $info['porPagina'] * ( $info['numEstaPagina'] - 1 ) );
        while ($log=$paginador->fetchResultado()){
	    $j++;
	    if ($num_fila%2!=0){
		$class="class='odd'";
	    }
	    else{
		$class="";
	    }?>
	<tr <? echo $class;?>>
	    <td><? echo $log['id'];?></td>
	    <td><? echo $utilidades->cambiarFecha($log['fecha'],0);?></td>
	    <td><? echo $log['ip'];?></td>
	    <td><? echo $log['username'];?></td>
	</tr>
	<?php
	$num_fila++;
	$j++;
	}?>
	<tr><td colspan="4">&nbsp;</td></tr>
    </table>    
    <? echo "<div id='navigation'>".$paginador->fetchNavegacion()."</div>";?>
