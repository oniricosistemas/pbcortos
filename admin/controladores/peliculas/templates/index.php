<?
if (!empty($mensaje)) {
    echo $mensaje;
}
?>
    <h2><a class="ajax" href="index.php?controlador=peliculas&amp;accion=nuevoPeliculas" title="Crear Nueva Peliculas">Crear Nueva Peliculas</a></h2>
    <h3>Listado de Peliculas </h3>
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
        while ($peliculas=$paginador->fetchResultado()) {
            $j++;
            if ($num_fila%2!=0) {
                $class="class='odd'";
            }
            else {
                $class="";
            }?>
        <tr <? echo $class;?>>
            <td><? echo $peliculas['id'];?></td>
            <td><? echo $peliculas['titulo'];?></td>
            <td><? echo $peliculas['edicion'];?></td>
            <td class="action">
                <a class="edit ajax" href="index.php?controlador=peliculas&amp;accion=editarPeliculas&amp;id=<? echo $peliculas['id'];?>" title="Editar Peliculas">
        									Editar
                </a>
                <a class="delete" href="index.php?controlador=peliculas&amp;accion=borrarPeliculas&amp;id=<? echo $peliculas['id'];?>" title="Borrar Peliculas">
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


