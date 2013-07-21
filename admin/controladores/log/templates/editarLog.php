    <?
    if(!empty($mensaje)) {
        echo $mensaje;
    }
    ?>
    <h2>&laquo; <a href="index.php?controlador=log" class="ajax" title="volver">Volver</a></h2>
    <?
    //$debug->log($datos);
    preg_match('~^\[(.*?)\]~', $datos, $date);
    preg_match('~\] \[([A-Za-z0-9\._-]*?)\] \[~', $datos, $nivel);
    preg_match('~\] \[tipo ([A-Za-z\.]*)\]~', $datos, $tipo);
    preg_match('~\] (.*)$~', $datos, $message);
    ?>
    <h3>Detalle Log</h3>

    <table cellpadding="0" cellspacing="0" summary="">
        <tr>
            <td>Fecha:</td>
            <td><? echo $utilidades->cambiarFecha(str_replace('[','',$date[1]),0);?></td>
        </tr>
        <tr>
            <td>Nivel de Error:</td>
            <td><? echo $nivel[1];?></td>
        </tr>
        <tr>
            <td>Tipo:</td>
            <td><? echo $tipo[1];?></td>
        </tr>
        <tr>
            <td>Error:</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                <?
                $pos = ( strrpos($message[1], ']') ) + 1;

                echo substr( $message[1], $pos, strlen($message[1]) );
                ?>
            </td>
        </tr>
    </table>
