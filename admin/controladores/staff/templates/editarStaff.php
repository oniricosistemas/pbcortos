<?
    if(!empty($mensaje)){
    echo $mensaje;
    }
    ?>
<h2><a href="index.php?controlador=staff" title="volver">Volver</a></h2>
    <h3><? if($_REQUEST['accion']=='nuevaStaff' || $_REQUEST['accion']=='crearStaff'){ echo "Crear Staff";}else{ echo "Editar Staff";}?></h3>
    <form action="index.php?controlador=staff&amp;accion=guardarStaff" method="post" class="jNice" enctype="multipart/form-data">
          <div class="portlet2">
            <div class="portlet2-header">Opciones Staff</div>
            <div class="portlet2-content">
                <fieldset>
                    <p><label>Nombre:</label><input type="text" class="text-long" name="nombre" value="<? echo $datos->nombre;?>"/></p>
		    <p><label>Cargo:</label><input type="text" class="text-long" name="cargo" value="<? echo $datos->cargo;?>"/></p>
                    <p><label>Edición a la que pertenece el staff:</label>
                    <select name="id_edicion">
                        <option value="">Seleccione una edición</option>
                        <?php
                        foreach ($ediciones as $value) {?>
                            <option value="<?php echo $value['id'];?>" <?php if($datos->id_edicion==$value['id']){echo "selected='selected'";}?>><?php echo $value['titulo'];?></option>
                        <?php
                        }
                        ?>
                    </select>
                </p>
                </fieldset>
            </div>
        </div>
        
        <fieldset>
            <input type="hidden" name="id"  value="<? echo $datos->id;?>"/>
            <input type="submit" value="Guardar" />
        </fieldset>
    </form>
</div>
<!-- // #main -->
<div class="clear"></div>
