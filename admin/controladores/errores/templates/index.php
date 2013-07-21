    <?
    if(!empty($mensaje)){
        echo $mensaje;   
    }    
    ?>
    <?php
    if ($paginador->numTotalRegistros()!=0){?>
    <h2><a class="ajax" href="index.php??controlador=errores&amp;accion=limpiarErrores" title="Limpiar registro de Errores">Limpiar registro de Errores</a></h2>
    <?php
    }
    ?>
    <h3>Listado de Errores </h3>
    <div class="portlet">
	<div class="portlet-header">Filtros de Búsqueda</div>
	<div class="portlet-content">
	    <form action="index.php?controlador=errores&amp;accion=index" method="post">
		<div class="filtro">
		    <label>Fecha entre : </label><input type="text" class="text-short" readonly="readonly" id="datepicker" name="inicio" value=""/> Y <input type="text" class="text-short" readonly="readonly" id="datepicker2" name="fin" value=""/>
		</div>
		<div class="filtro">
		    <label>Tipo de Error: </label>
		    <select name="codigo">
			<option value="">&nbsp;</option>
			<option value="1">E_ERROR</option>
			<option value="2">E_WARNING</option>
			<option value="4">E_PARSE</option>
			<option value="8">E_NOTICE</option>
			<option value="16">E_CORE_ERROR</option>
			<option value="32">E_CORE_WARNING</option>
			<option value="64">E_COMPILE_ERROR</option>
			<option value="128">E_COMPILE_WARNING</option>
			<option value="256">E_USER_ERROR</option>
			<option value="512">E_USER_WARNING</option>
			<option value="1024">E_USER_NOTICE</option>
			<option value="2048">E_STRICT</option>
			<option value="4096">E_RECOVERABLE_ERROR</option>
			<option value="8192">E_DEPRECATED</option>
			<option value="16384">E_USER_DEPRECATED</option>
			<option value="30719">E_ALL</option>
		    </select>
		</div>
		<div class="clear"></div>
		<div class="filtro">
		    <label>Ordenar por: </label>
		    <select name="order">
			<option value="">&nbsp;</option>
			<option value="id">ID</option>			
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
		$link = $utilidades->linkOrdenar('index.php?controlador=errores&amp;accion=index&amp;order=id',$_REQUEST,'id');
		?>
		<th><a href="<?php echo $link['url'];?>" class="ajax" title="<?php echo ucfirst($link['por']);?>"><img src="<?php if($link['seleccion']=='id'){echo $img.$link['icon'];}else{echo $img.'upDown';}?>.png" alt="<?php if($link['seleccion']=='id'){echo ucfirst($link['por']);}else{echo 'Descendente';}?>"/></a> #</th>
		<?php
		$img = $config->get('urlRoot').'/'.$config->get('adminViewsFolder').'images/';
		$link = $utilidades->linkOrdenar('index.php?controlador=errores&amp;accion=index&amp;order=fecha',$_REQUEST,'fecha');
		?>
		<th><a href="<?php echo $link['url'];?>" class="ajax" title="<?php echo ucfirst($link['por']);?>"><img src="<?php if($link['seleccion']=='fecha'){echo $img.$link['icon'];}else{echo $img.'upDown';}?>.png" alt="<?php if($link['seleccion']=='fecha'){echo ucfirst($link['por']);}else{echo 'Descendente';}?>"/></a> Fecha</th>
		<th>Error</th>
		<?php
		$img = $config->get('urlRoot').'/'.$config->get('adminViewsFolder').'images/';
		$link = $utilidades->linkOrdenar('index.php?controlador=errores&amp;accion=index&amp;order=codigo',$_REQUEST,'codigo');
		?>
		<th><a href="<?php echo $link['url'];?>" class="ajax" title="<?php echo ucfirst($link['por']);?>"><img src="<?php if($link['seleccion']=='codigo'){echo $img.$link['icon'];}else{echo $img.'upDown';}?>.png" alt="<?php if($link['seleccion']=='codigo'){echo ucfirst($link['por']);}else{echo 'Descendente';}?>"/></a> Tipo</th>
		<th>&nbsp;</th>
	    </tr>
	</thead>
	<?
        $num_fila = 1;
        $info = $paginador->superArray();
        $i=1 + ( $info['porPagina'] * ( $info['numEstaPagina'] - 1 ) );
        while ($errores=$paginador->fetchResultado()){
	    $j++;
	    if ($num_fila%2!=0){
		$class="class='odd'";
	    }
	    else{
		$class="";
	    }?>
	<tr <? echo $class;?>>
	    <td><? echo $errores['id'];?></td>
	    <td><? echo $utilidades->cambiarFecha($errores['fecha'],1);?></td>
	    <td><? echo $utilidades->cortarTexto($errores['error'],40,array('ending' => '...', 'exact' => true, 'html' => false));?></td>
	    <td><? echo $utilidades->valorError($errores['cod_error']);?></td>
	    <td class="action">
		<a class="edit ajax" href="index.php?controlador=errores&amp;accion=verError&amp;id=<? echo $errores['id'];?>" title="Detalle Error">
        									Detalle
		</a>
	    </td>
	</tr>
	<?php
	$num_fila++;
	$j++;
	}?>	
	<tr><td colspan="5">&nbsp;</td></tr>
    </table>    
    <? echo "<div id='navigation'>".$paginador->fetchNavegacion()."</div>";?>
