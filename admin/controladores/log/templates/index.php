    <?
    if(!empty($mensaje)) {
        echo $mensaje;
    }
    ?>
    <?php
    if($datos[0]!=''){?>
    <h2><a class="ajax" href="index.php?controlador=log&amp;accion=limpiarLog" title="Limpia el archivo de Log">Limpia el archivo de Log</a></h2>
    <?php
    }
    ?>
    <h3>Listado Log de Errores </h3>
    <table cellpadding="0" cellspacing="0" summary="">
	<thead>
	    <tr>
		<th>#</th>
		<th>Fecha</th>
		<th>Nivel</th>
		<th>Tipo</th>
		<th>&nbsp;</th>
	    </tr>
	</thead>
	<?
        $num_fila = 1;
	$j=0;
        foreach($datos as $i => $line) {	    
	    if ($num_fila%2!=0){
		$class="class='odd'";
	    }
	    else{
		$class="";
	    }
	   preg_match('~^\[(.*?)\]~', $line, $date);
	    if(empty($date[1])) {
	    continue;
	    }
	    preg_match('~\] \[([A-Za-z0-9\._-]*?)\] \[~', $line, $nivel);
	    preg_match('~\] \[tipo ([A-Za-z\.]*)\]~', $line, $tipo);
	    preg_match('~\] (.*)$~', $line, $message);
	    //$debug->log(preg_replace("%\[[^\]]+\]%",'',$message[1]));
	    ?>
	<tr <? echo $class;?>>
	    <td><? echo $j;?></td>
	    <td><? echo $utilidades->cambiarFecha(str_replace('[','',$date[1]),0);?></td>
	    <td><? echo $nivel[1];?></td>
	    <td><? echo $tipo[1];?></td>
	    <td class="action">
		<a class="edit ajax" href="index.php" onclick="envioAjax('index.php?controlador=log&amp;accion=verLog&amp;linea=<? echo $j;?>');return false;" title="Detalle Error">
                    Detalle
		</a>
	    </td>
	</tr>
	<?php
	$num_fila++;
	$j++;
	}?>
	<tr><td colspan="7">&nbsp;</td></tr>
    </table>