<?php
$route['index/pagina/(:num)'] = "index/index/$1";
$route['inicio/pagina/(:num)'] = "index/index/$1";
$route['inicio'] = "index/";

$route['noticias/(:any)'] = "noticias/index/$1";
$route['peliculas-invitadas'] = "peliculas";
$route['ediciones-anteriores'] = "ediciones";
/* Basicos */
$route['index'] = "index";
$route['error404'] = "error404";






?>
