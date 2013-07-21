    <?
    if(!empty($mensaje)) {
        echo $mensaje;
    }
    ?>
    <h2><a href="index.php?controlador=usuarios" class="ajax" title="volver">Volver</a></h2>
    <h3><? if($_REQUEST['accion']=='nuevoUsuarios' || $_REQUEST['accion']=='crearUsuarios'){ echo "Crear Usuarios";}else{ echo "Editar Usuarios";}?></h3>
    <form action="index.php?controlador=usuarios&amp;accion=guardarUsuarios" method="post" class="jNice" enctype="multipart/form-data">
	  <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Perfil</a></li>
                <li><a href="#tabs-2">Permisos</a></li>
            </ul>
            <div id="tabs-1">
                <fieldset>
		    <p><label>Nombre de usuario:</label>
			<input type="text" class="text-long" name="username" value="<?php echo $datos->username;?>"/>
		    </p>
		    <p><label>Contrase&ntilde;a:</label>
			<input type="password" class="text-long" name="password" value=""/>
			<input type="hidden" class="text-long" name="clave" value="<?php echo $datos->password;?>"/>
		    </p>
		    <p><label>Email: </label>
			<input type="text" class="text-long" name="email" value="<?php echo $datos->email;?>"/>
		    </p>
		    <p><label>Nombre: </label>
			<input type="text" class="text-long" name="nombre" value="<?php echo $datos->nombre;?>"/>
		    </p>
		    <p><label>Apellido</label>
			<input type="text" class="text-long" name="apellido" value="<?php echo $datos->apellido;?>"/>
		    </p>
		    <p><label>Estado</label>
			<select name="estado">
			    <option value="">Seleccione un estado</option>
			    <option value="nuevo" <?php if($datos->estado=='nuevo'){echo "selected='selected'";}?>>Nuevo</option>
			    <option value="activo" <?php if($datos->estado=='activo'){echo "selected='selected'";}?>>Activado</option>
			    <option value="desactivado" <?php if($datos->estado=='desactivado'){echo "selected='selected'";}?>>Desactivado</option>

			</select>
		    </p>
		</fieldset>
            </div>
            <div id="tabs-2">
                <fieldset>		    
                    <?php
		    if(!empty($permisos)){
			$per = unserialize($permisoUsuario->permisos);
                        if(!$per){?>
                        <p><input type="checkbox" name="checktodos" checked="checked"  value="1"/>Administrador</p>
                        <?php
                        }
                        else{?>
                        <p><input type="checkbox" name="checktodos" value="1"/>Administrador</p>
                        <?php
                        }
			for($i=0;$i<count($permisos);$i++){?>
			<p><?php echo ucfirst($permisos[$i]['nombre']);?></p>
			<?php
			    $total = count($permisos[$i]);
			    for($j=0;$j<$total;$j++){
				if(!empty($permisos[$i][$j])){?>
				    <p style="padding-left: 20px;">
					<input type="checkbox" name="controladores[]" value="<?php echo $permisos[$i]['nombre'].':'.$permisos[$i][$j]; ?>"
				<?php
				    if(!empty($per)){
					for($k=0;$k<count($per);$k++){				    
					    if($per[$k]==$permisos[$i]['nombre'].':'.$permisos[$i][$j]){
						echo "checked='checked'";
					    }
					}
				    }
				    ?>
					/><?php echo $permisos[$i][$j];?>
				    </p>
				<?php
				}
			    }
			};
		    }
		    ?>
                <input type="hidden" name="permisos_id"  value="<? echo $permisoUsuario->id;?>"/>
                </fieldset>
            </div>
        </div>
	<br/>
	<fieldset>
	    <input type="hidden" name="id"  value="<? echo $datos->id;?>"/>
            <input type="hidden" name="superadmin"  value="<? echo $datos->superadmin;?>"/>
	    <input type="submit" value="Guardar" />
	</fieldset>

    </form>