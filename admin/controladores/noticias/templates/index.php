<?
if (!empty($mensaje)) {
    echo $mensaje;
}
?>
    <h2><a class="ajax" href="index.php?controlador=noticias&amp;accion=nuevoNoticias" title="Crear Nueva Noticias">Crear Nueva Noticias</a></h2>
    <h3>Listado de Noticias </h3>
    <table cellpadding="0" cellspacing="0" summary="">
        <thead>
            <tr>
                <th>#</th>
                <th>Titulo</th>
                <th>Edición</th>
                <th>Fecha</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <?
        $num_fila = 1;
        $info = $paginador->superArray();
        $i=1 + ( $info['porPagina'] * ( $info['numEstaPagina'] - 1 ) );
        while ($noticias=$paginador->fetchResultado()) {
            $j++;
            if ($num_fila%2!=0) {
                $class="class='odd'";
            }
            else {
                $class="";
            }?>
        <tr <? echo $class;?>>
            <td><? echo $noticias['id'];?></td>
            <td><? echo $noticias['titulo'];?></td>
            <td><? echo $noticias['edicion'];?></td>
            <td><? echo $noticias['fecha'];?></td>
            <td class="action">
                <a class="edit ajax" href="index.php?controlador=noticias&amp;accion=editarNoticias&amp;id=<? echo $noticias['id'];?>" title="Editar Noticias">
        									Editar
                </a>
                <a class="delete" href="index.php?controlador=noticias&amp;accion=borrarNoticias&amp;id=<? echo $noticias['id'];?>" title="Borrar Idioma">
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


