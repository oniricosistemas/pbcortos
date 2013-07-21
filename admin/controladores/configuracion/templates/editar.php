    <?
    if(!empty($mensaje)) {
        echo $mensaje;
    }
    ?>
    <h2>&laquo; <a href="index.php?controlador=configuracion" class="ajax" title="volver">Volver</a></h2>
    <h3>Editar configuración General del Sitio</h3>

    <form action="index.php?controlador=configuracion&accion=guardarConfiguracion" method="post" id="form" class="jNice">
        <fieldset>
            <p>
                <label>Titulo:</label>
                <input type="text" class="text-long" name="titulo" value="<? echo $datos['titulo'];?>"/>
            </p>
            <p>
                <label>Descripción:</label>
                <textarea name="descripcion" rows="0" cols="0"><? echo $datos['descripcion'];?></textarea>
            </p>
            <p>
                <label>Keywords:</label>
                <input type="text" class="text-long" name="keywords" value="<? echo $datos['keywords'];?>"/>
            </p>
            <p>
                <label>Email principal:</label>
                <input type="text" class="text-long" name="email" value="<? echo $datos['email'];?>"/>
            </p>
            <p>
                <label>Nombre de usuario email:</label>
                <input type="text" class="text-long" name="user_email" value="<? echo $datos['user_email'];?>"/>
            </p>
            <p>
                <label>Contraseña usuario email:</label>
                <input type="text" class="text-long" name="pass_email" value="<? echo $datos['pass_email'];?>"/>
            </p>
            <p>
                <label>Puerto servidor email:</label>
                <input type="text" class="text-long" name="port_email" value="<? echo $datos['port_email'];?>"/>
            </p>
            <p>
                <label>Host servidor email:</label>
                <input type="text" class="text-long" name="host_email" value="<? echo $datos['host_email'];?>"/>
            </p>
            <p>
                <label>Sitio Activo:</label>
                <select name="activo">
                    <option value="1" <?php if($datos['activo']==1){echo "selected='selected'";}?>>Si</option>
                    <option value="0" <?php if($datos['activo']==0){echo "selected='selected'";}?>>No</option>
                </select>
            </p>
            <p>
                <label>Sitio en Construcción:</label>
                <select name="construccion">
                    <option value="1" <?php if($datos['construccion']==1){echo "selected='selected'";}?>>Si</option>
                    <option value="0" <?php if($datos['construccion']==0){echo "selected='selected'";}?>>No</option>
                </select>
            </p>
            <input type="hidden" value="1" name="id"/>
            <input type="submit" value="Editar" id="enviar" />
        </fieldset>
    </form>
