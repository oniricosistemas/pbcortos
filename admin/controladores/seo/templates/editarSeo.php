    <?
    if(!empty($mensaje)) {
        echo $mensaje;
    }
    ?>    
    <h2><a href="index.php?controlador=seo" class="ajax" title="<?php echo $leng['volver'];?>"><?php echo $leng['volver'];?></a></h2>
    <h3><? if($_REQUEST['accion']=='nuevoSeo' || $_REQUEST['accion']=='crearSeo') {
            echo $leng['nuevoSeo'];
        }else {
            echo $leng['editSeo'];
        }?></h3>
    <form action="index.php?controlador=seo&amp;accion=<?if($_REQUEST['accion']!='editarSeo' && $_REQUEST['accion']!="guardarSeo") {
        echo "crearSeo";
    }else {
        echo "guardarSeo";
          }?>" method="post" class="jNice" enctype="multipart/form-data">
              <?php
              if($config->get('multi')) {
                  if(is_array($lang)) {?>
        <div id="tabs">
            <ul>
                        <?php
                        $i=0;
                        foreach ($lang as $key => $val) {?>
                <li><a href="#tabs-<?php echo $i;?>"><?php echo $val['idioma'];?></a></li>
                            <?php
                            $i++;
                        }
                        ?>
            </ul>
                    <?php
                    $total=count($lang);
                    for($j=0;$j<$total;$j++) {?>
            <div id="tabs-<?php echo $j;?>">
                <fieldset>
                    <p><label><?php echo $leng['titulo'];?>:</label>
                                    <?php
                                    $hay=0;
                                    for($k=0;$k<count($datos);$k++) {
                                        if($datos[$k]['siglas']==$lang[$j]['siglas']) {?>
                        <input type="text" class="text-long" name="seo[<?php echo $lang[$j]['siglas'];?>][titulo]" value="<?php echo trim($datos[$k]['titulo']);?>"/>
                        <!-- guardo los id y las siglas para recueprarlas mas tarde -->
                        <input type="hidden" class="text-long" name="seo[<?php echo $lang[$j]['siglas'];?>][siglas]" value="<?php echo trim($lang[$j]['siglas']);?>"/>
                        <input type="hidden" class="text-long" name="seo[<?php echo $lang[$j]['siglas'];?>][seccion]" value="<?php echo trim($datos[$k]['seccion']);?>"/>
                        <input type="hidden" class="text-long" name="seo[<?php echo $lang[$j]['siglas'];?>][subseccion]" value="<?php echo trim($datos[$k]['accion']);?>"/>
                        <input type="hidden" class="text-long" name="seo[<?php echo $lang[$j]['siglas'];?>][id]" value="<?php echo trim($datos[$k]['seo_id']);?>"/>
                        <input type="hidden" class="text-long" name="seo[<?php echo $lang[$j]['siglas'];?>][id_leng]" value="<?php echo trim($datos[$k]['id_leng']);?>"/>
                                            <?php
                                            $hay++;
                                        }
                                        ?>

                                        <?php
                                    }
                                    if($hay==0) {
                                        ?>
                        <input type="text" class="text-long" name="seo[<?php echo $lang[$j]['siglas'];?>][titulo]" value=""/>
                        <!-- guardo los id y las siglas para recueprarlas mas tarde -->
                        <input type="hidden" class="text-long" name="seo[<?php echo $lang[$j]['siglas'];?>][siglas]" value="<?php echo $lang[$j]['siglas'];?>"/>
                        <input type="hidden" class="text-long" name="seo[<?php echo $lang[$j]['siglas'];?>][seccion]" value="<?php if (!empty($datos[0]['seccion'])) {
                                            echo trim($datos[0]['seccion']);
                                        }else {
                                            echo $datos['seccion'];
                                               }?>"/>
                        <input type="hidden" class="text-long" name="seo[<?php echo $lang[$j]['siglas'];?>][subseccion]" value="<?php if (!empty($datos[0]['accion'])) {
                                            echo trim($datos[0]['accion']);
                                        }else {
                                            echo $datos['accion'];
                                               }?>"/>
                        <input type="hidden" class="text-long" name="seo[<?php echo $lang[$j]['siglas'];?>][nombres]" value="<?php if (!empty($datos[0]['nombres'])) {
                                            echo trim($datos[0]['nombres']);
                                        }else {
                                            echo $datos['nombres'];
                                               }?>"/>
                        <input type="hidden" class="text-long" name="seo[<?php echo $lang[$j]['siglas'];?>][id]" value=""/>
                        <input type="hidden" class="text-long" name="seo[<?php echo $lang[$j]['siglas'];?>][id_leng]" value="<?php echo $lang[$j]['id'];?>"/>
                                        <?php
                                    }
                                    ?>
                    </p>
                    <p><label><?php echo $leng['descripcion'];?>:</label>
                        <textarea name="seo[<?php echo $lang[$j]['siglas'];?>][descripcion]" rows="40" cols="8">
                                        <?
                                        for($k=0;$k<count($datos);$k++) {
                                            if($datos[$k]['siglas']==$lang[$j]['siglas']) {
                                                echo trim($datos[$k]['descripcion']);
                                            }
                                        }
                                        ?>
                        </textarea>
                    </p>
                    <p><label>Keywords:</label>
                        <textarea name="seo[<?php echo $lang[$j]['siglas'];?>][keywords]" rows="40" cols="8"><?
                                        for($k=0;$k<count($datos);$k++) {
                                            if($datos[$k]['siglas']==$lang[$j]['siglas']) {
                                                echo trim($datos[$k]['keywords']);
                                            }
                                        }
                                        ?></textarea>
                    </p>
                </fieldset>
            </div>
                        <?php
                    }
                    ?>
            <input type="hidden" class="text-long" name="seo[seccion]" value="<?php if (!empty($datos[0]['seccion'])) {
                        echo trim($datos[0]['seccion']);
                    }else {
                        echo $datos['seccion'];
                           }?>"/>
            <input type="hidden" class="text-long" name="seo[subaccion]" value="<?php if (!empty($datos[0]['accion'])) {
                        echo trim($datos[0]['accion']);
                    }else {
                        echo $datos['accion'];
                           }?>"/>
            <input type="hidden" class="text-long" name="seo[nombres]" value="<?php if (!empty($datos[0]['nombres'])) {
                        echo trim($datos[0]['nombres']);
                    }else {
                        echo $datos['nombre'];
                           }?>"/>
        </div>
        <br/>
        <fieldset>
            <input type="submit" value="<?php echo $leng['guardar'];?>" />
        </fieldset>
                <?php
            }
        }
        else {
            $debug->log($datos);
            ?>
        <fieldset>
            <p><label><?php echo $leng['titulo'];?>:</label><input type="text" class="text-long" name="titulo" value="<? echo $datos[0]['titulo'];?>"/></p>
            <p><label><?php echo $leng['descripcion'];?>:</label>
                <textarea name="descripcion" rows="40" cols="8"><? echo $datos[0]['descripcion'];?></textarea>
            </p>
            <p><label>Keywords:</label>
                <textarea name="keywords" rows="40" cols="8"><? echo $datos[0]['keywords'];?></textarea>
            </p>
                <?php
                if($config->get('seo')) {?>
            <p><label><?php echo $leng['nombre'];?>:</label><input type="text" class="text-long" name="nombres" value="<? echo $datos[0]['nombres'];?>"/></p>
            <p><label><?php echo $leng['seccion'];?>:</label><input type="text" class="text-long" name="seccion" value="<? echo $datos[0]['seccion'];?>"/></p>
            <p><label><?php echo $leng['accion'];?>:</label><input type="text" class="text-long" name="subaccion" value="<? echo $datos[0]['subaccion'];?>"/></p>
                    <?php
                }
                else {?>
            <input type="hidden" class="text-long" name="nombres" value="<? echo $datos[0]['nombres'];?>"/>
            <input type="hidden" class="text-long" name="seccion" value="<? echo $datos[0]['seccion'];?>"/>
            <input type="hidden" class="text-long" name="subaccion" value="<? echo $datos[0]['subaccion'];?>"/>
                    <?php
                }
                ?>
            <input type="hidden" name="id"  value="<? echo $datos[0]['seo_id'];?>"/>
            <input type="submit" value="<?php echo $leng['guardar'];?>" />
        </fieldset>
            <?php
        }
        ?>
    </form>