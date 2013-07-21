    <?
    if(!empty($mensaje)) {
        echo $mensaje;
    }
    ?>
    <h2><a class="ajax" href="index.php?controlador=secciones&amp;accion=nuevoSecciones" title="Crear Nueva Sección">Crear Nueva Sección</a></h2>
    <h3>Listado de Secciones </h3>
    <table cellpadding="0" cellspacing="0" summary="">
        <thead>
            <tr>
                <th>#</th>
                <th>Titulo</th>
                <th>Edición</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <?
        $num_fila = 1;
        $info = $paginador->superArray();
        $i=1 + ( $info['porPagina'] * ( $info['numEstaPagina'] - 1 ) );
        while ($secciones=$paginador->fetchResultado()) {
            $j++;
            if ($num_fila%2!=0) {
                $class="class='odd'";
            }
            else {
                $class="";
            }?>
        <tr <? echo $class;?>>
            <td><? echo $secciones['id'];?></td>
            <td><? echo $secciones['titulo'];?></td>
            <td><? echo $secciones['edicion'];?></td>
            <td class="action">
                <a class="edit ajax" href="index.php?controlador=secciones&amp;accion=editarSecciones&amp;id=<? echo $secciones['id'];?>" title="Editar Sección">
        									Editar
                </a>
                <!--<a class="delete" onclick="if (ask()) window.location='index.php?controlador=secciones&amp;accion=borrarSecciones&amp;id=<? echo $secciones['id'];?>'" href="#" title="Borrar Idioma">
									Borrar
                </a>-->
            </td>
        </tr>
            <?php
            $num_fila++;
        }?>
        <tr><td colspan="7">&nbsp;</td></tr>
    </table>
    <? echo "<div id='navigation'>".$paginador->fetchNavegacion()."</div>";?>


