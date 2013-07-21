    <h2>&laquo; <a href="index.php?controlador=errores" class="ajax" title="volver">Volver</a></h2>
    <?
    if(!empty($mensaje)){
	echo $mensaje;
    }
    ?>
    <h3>Detalle Error</h3>

    <table cellpadding="0" cellspacing="0" summary="">
        <tr>
            <td>Fecha:</td>
            <td><? echo $utilidades->cambiarFecha(str_replace('[','',$datos->fecha),0);?></td>
        </tr>
        <tr>
            <td>Tipo de Error:</td>
            <td><? echo $utilidades->valorError($datos->cod_error);?></td>
        </tr>
        <tr>
            <td>Archivo:</td>
            <td><? echo $datos->accion;?></td>
        </tr>
	<tr>
            <td>Linea:</td>
            <td><? echo $datos->linea;?></td>
        </tr>
	<tr>
            <td>Id Usuario:</td>
            <td><? echo $datos->user_id;?></td>
        </tr>
        <tr>
            <td>Error:</td>
	    <td>&nbsp;</td>
        </tr>
	<tr>
            <td colspan="2">
		<? echo $datos->error;?>
	    </td>
        </tr>
    </table>