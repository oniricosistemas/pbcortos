    <?
    if(!empty($mensaje)) {
        echo $mensaje;
    }
    ?>    
    <h2><a class="ajax" href="index.php?controlador=usuarios&amp;accion=nuevoUsuarios" title="Crear Nuevo Usuario">Crear Nuevo Usuario</a></h2>
    <h3>Listado de Usuarios </h3>
    <div class="portlet">
	<div class="portlet-header">Filtros de Búsqueda</div>
	<div class="portlet-content">
	    <form action="index.php?controlador=usuarios&amp;accion=index" method="post">
		<div class="filtro">
		    <label>Nombre de Usuario: </label><input type="text" class="text-short" name="username" value=""/>
		</div>
		<div class="filtro">
		    <label>Nombre/Apellido: </label><input type="text" class="text-short" name="nombre" value=""/>
		</div>
		<div class="filtro">
		    <label>Email: </label><input type="text" class="text-short" name="email" value=""/>
		</div>		
		<div class="filtro">
		    <label>Ordenar por: </label>
		    <select name="order">
			<option value="">&nbsp;</option>
			<option value="id">ID</option>
			<option value="email">Email</option>
			<option value="nombre">Nombre</option>
			<option value="usuario">Username</option>
		    </select>
		</div>
		
		<div class="filtro">
		    <button type="submit"> <img src="<?php echo $config->get('urlRoot').$config->get('adminViewsFolder').'images/';?>search.png" alt="buscar" class="imagcentrar"/></button>
		</div>
	    </form>
	</div>
    </div>
    <table cellpadding="0" cellspacing="0" summary="">
	<thead>
	    <tr>
		<?php
		$img = $config->get('urlRoot').'/'.$config->get('adminViewsFolder').'images/';
		$link = $utilidades->linkOrdenar('index.php?controlador=usuarios&amp;accion=index&amp;order=id',$_REQUEST,'id');
		?>
		<th><a href="<?php echo $link['url'];?>" class="ajax" title="<?php echo ucfirst($link['por']);?>"><img src="<?php if($link['seleccion']=='id'){echo $img.$link['icon'];}else{echo $img.'upDown';}?>.png" alt="<?php if($link['seleccion']=='id'){echo ucfirst($link['por']);}else{echo '';}?>"/></a> #</th>
		<?php
		$img = $config->get('urlRoot').'/'.$config->get('adminViewsFolder').'images/';
		$link = $utilidades->linkOrdenar('index.php?controlador=usuarios&amp;accion=index&amp;order=username',$_REQUEST,'username');
		?>
		<th><a href="<?php echo $link['url'];?>" class="ajax" title="<?php echo ucfirst($link['por']);?>"><img src="<?php if($link['seleccion']=='username'){echo $img.$link['icon'];}else{echo $img.'upDown';}?>.png" alt="<?php if($link['seleccion']=='username'){echo ucfirst($link['por']);}else{echo '';}?>"/></a> Usuario</th>
		<?php
		$img = $config->get('urlRoot').'/'.$config->get('adminViewsFolder').'images/';
		$link = $utilidades->linkOrdenar('index.php?controlador=usuarios&amp;accion=index&amp;order=nombre',$_REQUEST,'nombre');
		?>
		<th><a href="<?php echo $link['url'];?>" class="ajax" title="<?php echo ucfirst($link['por']);?>"><img src="<?php if($link['seleccion']=='nombre'){echo $img.$link['icon'];}else{echo $img.'upDown';}?>.png" alt="<?php if($link['seleccion']=='nombre'){echo ucfirst($link['por']);}else{echo '';}?>"/></a> Nombre</th>
		<?php
		$img = $config->get('urlRoot').'/'.$config->get('adminViewsFolder').'images/';
		$link = $utilidades->linkOrdenar('index.php?controlador=usuarios&amp;accion=index&amp;order=email',$_REQUEST,'email');
		?>
		<th><a href="<?php echo $link['url'];?>" class="ajax" title="<?php echo ucfirst($link['por']);?>"><img src="<?php if($link['seleccion']=='email'){echo $img.$link['icon'];}else{echo $img.'upDown';}?>.png" alt="<?php if($link['seleccion']=='email'){echo ucfirst($link['por']);}else{echo '';}?>"/></a> Email</th>
		<?php
		$img = $config->get('urlRoot').'/'.$config->get('adminViewsFolder').'images/';
		$link = $utilidades->linkOrdenar('index.php?controlador=usuarios&amp;accion=index&amp;order=estado',$_REQUEST,'estado');
		?>
		<th><a href="<?php echo $link['url'];?>" class="ajax" title="<?php echo ucfirst($link['por']);?>"><img src="<?php if($link['seleccion']=='estado'){echo $img.$link['icon'];}else{echo $img.'upDown';}?>.png" alt="<?php if($link['seleccion']=='estado'){echo ucfirst($link['por']);}else{echo '';}?>"/></a> Estado</th>
		<th>&nbsp;</th>
	    </tr>
	</thead>
	<?
        $num_fila = 1;
        $info = $paginador->superArray();
        $i=1 + ( $info['porPagina'] * ( $info['numEstaPagina'] - 1 ) );
        while ($usuarios=$paginador->fetchResultado()){
	    $j++;
	    if ($num_fila%2!=0){
		$class="class='odd'";
	    }
	    else{
		$class="";
	    }?>
	<tr <? echo $class;?>>
	    <td><? echo $usuarios['id'];?></td>
	    <td><? echo $usuarios['username'];?></td>
	    <td><? echo $usuarios['nombre']." ".$usuarios['apellido'];?></td>
	    <td><? echo $usuarios['email'];?></td>
	    <td><? echo $usuarios['estado'];?></td>
	    <td class="action">
		<a class="edit ajax" href="index.php?controlador=usuarios&amp;accion=editarUsuarios&amp;id=<? echo $usuarios['id'];?>" title="Editar Usuario">
        									Editar
		</a>
		<a class="delete" href="index.php?controlador=usuarios&amp;accion=borrarUsuarios&amp;id=<? echo $usuarios['id'];?>" title="Borrar Usuario">
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