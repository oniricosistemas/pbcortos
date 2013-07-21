    <?
    if(!empty($mensaje)){
        echo $mensaje;
    }
    ?>   
    <h2><a href="index.php?controlador=configuracion&amp;accion=editarConfiguracion" class="ajax" title="editar">Editar Configuración</a>
    <h3>Configuración General del Sitio</h3>
    <table cellpadding="0" cellspacing="0" summary="">
        <tr>
            <td>Titulo del Sitio</td>
            <td><? echo $datos['titulo'];?></td>
        </tr>
        <tr>
            <td>Descripción del Sitio</td>
            <td><? echo $datos['descripcion'];?></td>
        </tr>
        <tr>
            <td>Keywords</td>
            <td><? echo $datos['keywords'];?></td>
        </tr>
        <tr>
            <td>Email principal</td>
            <td><? echo $datos['email'];?></td>
        </tr>
        <tr>
            <td>Nombre de usuario email</td>
            <td><? echo $datos['user_email'];?></td>
        </tr>
        <tr>
            <td>Contraseña email</td>
            <td><? echo $datos['pass_email'];?></td>
        </tr>
        <tr>
            <td>Puerto del email</td>
            <td><? echo $datos['port_email'];?></td>
        </tr>
        <tr>
            <td>Servidor del email</td>
            <td><? echo $datos['host_email'];?></td>
        </tr>
        <tr>
            <td>Sitio Activo</td>
            <td><? if($datos['activo']==1){echo "si";}else{echo "no";}?></td>
        </tr>
        <tr>
            <td>Sitio en construcción</td>
            <td><? if($datos['construccion']==1){echo "si";}else{echo "no";}?></td>
        </tr>
    </table>
    <br/>           

