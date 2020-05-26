<?php

/**
 * Cabecera HTML (prepend).
 *
 * @package awsw-gesi
 * Gesi
 * Aplicación de gestión de institutos de educación secundaria
 *
 * @author Andrés Ramiro Ramiro
 * @author Cintia María Herrera Arenas
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.2
 */

use \Awsw\Gesi\App;
use Awsw\Gesi\Formularios\Sesion\Cerrar;
use \Awsw\Gesi\Vistas\Vista;
use \Awsw\Gesi\Sesion;

$app = App::getSingleton();

$formulario_logout = new Cerrar('');
$formulario_logout->gestiona();

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo Vista::getPaginaActualNombre(); ?> - Gesi</title>

        <link rel="stylesheet" href="<?php echo $app->getUrl(); ?>/css/estilos.css<?php if ($app->isDesarrollo()) { echo "?v=" . time(); } ?>">
    </head>
    <body class="actual-<?php echo Vista::getPaginaActualId(); ?>">
        <div id="master-grid-wrapper">
            <header id="master-grid-header">
                <div id="app-logo">
                    <a href="<?php echo $app->getUrl(); ?>"><img src="<?php echo $app->getUrl(); ?>/img/logo.svg" height="24" width="24" alt="Gesi"></a>
                </div>

                <div id="app-name">
                    <h1><a href="<?php echo $app->getUrl(); ?>">Gesi</a></h1>
                </div>
            </header>

            <nav id="master-grid-user">
                <ul>
                    <?php

if (Sesion::isSesionIniciada()) {

    $u = Sesion::getUsuarioEnSesion();

    $nombre = $u->getNombreCompleto();

    $url_editar = $app->getUrl() . '/sesion/perfil/';
    
    $badges = '';
    $badges .= $u->isEst() ? '<span class="badge">Estudiante</span>' : '';
    $badges .= $u->isPd() ? '<span class="badge">Personal docente</span>' : '';
    $badges .= $u->isPs() ? '<span class="badge">Personal de Secretaría</span>' : '';


    
        
    echo <<< HTML
    <li>$badges</li>
    <li><a href="$url_editar">$nombre</a></li>
    <li>

    HTML;

    $formulario_logout->imprime();

    echo <<< HTML
    </li>

    HTML;

} else {

    $url = $app->getUrl() . '/sesion/iniciar/';

    echo <<< HTML
    <li><a href="$url">Iniciar sesión</a></li>

    HTML;

}

                    ?>
                </ul>
            </nav>

            <nav id="master-grid-nav">
                <ul>
                    <?php

$url_inicio = $app->getUrl();

    echo <<< HTML
    <li class="link"><a href="$url_inicio">Inicio</a></li>

    HTML;

if (Sesion::isSesionIniciada()) {

    $url_mensajes = $app->getUrl() . '/mi/secretaria/';
    $url_asignaturas = $app->getUrl() . '/mi/asignaturas/';
    $url_horarios = $app->getUrl() . '/mi/asignaciones/horario/';
    $url_eventos = $app->getUrl() . '/mi/eventos/';
    $url_foros = $app->getUrl() . '/mi/foros/';
    $url_biblioteca = $app->getUrl() . '/mi/biblioteca/';

    echo <<< HTML
    <li class="divider">Acciones personales</li>
    <li class="link"><a href="$url_mensajes">Mensajes de Secretaría</a></li>
    <li class="link"><a href="$url_eventos">Eventos</a></li>
    <li class="link"><a href="$url_foros">Foros</a></li>
    <li class="link"><a href="$url_biblioteca">Biblioteca</a></li>

    HTML;

    if (Sesion::getUsuarioEnSesion()->isEst()) {

        echo <<< HTML
        <li class="divider">Acciones de estudiante</li>
        <li class="link"><a href="$url_asignaturas">Asignaturas</a></li>
        <li class="link"><a href="$url_horarios">Horarios</a></li>

        HTML;

    } elseif (Sesion::getUsuarioEnSesion()->isPd()) {
        
        $url_grupos = $app->getUrl() . '/mi/grupos/';
        $url_asignaciones = $app->getUrl() . '/mi/asignaciones/';

        echo <<< HTML
        <li class="divider">Acciones de personal docente</li>
        <li class="link"><a href="$url_asignaturas">Asignaturas</a></li>
        <li class="link"><a href="$url_horarios">Horarios</a></li>
        <li class="link"><a href="$url_grupos">Grupos</a></li>
        <li class="link"><a href="$url_asignaciones">Asignaciones</a></li>

        HTML;
    
    } elseif (Sesion::getUsuarioEnSesion()->isPs()) {

        $url_mensajes = $app->getUrl() . '/admin/secretaria/';
        $url_asignaturas = $app->getUrl() . '/admin/asignaturas/';
        $url_grupos = $app->getUrl() . '/admin/grupos/';
        $url_usuarios = $app->getUrl() . '/admin/usuarios/';
        $url_asignaciones = $app->getUrl() . '/admin/asignaciones/';
        $url_eventos = $app->getUrl() . '/admin/eventos/';
        $url_foros = $app->getUrl() . '/admin/foros/';
        $url_biblioteca = $app->getUrl() . '/admin/biblioteca/';

        echo <<< HTML
        <li class="divider">Acciones de administración</li>
        <li class="link"><a href="$url_mensajes">Mensajes de Secretaría</a></li>
        <li class="link"><a href="$url_asignaturas">Asignaturas</a></li>
        <li class="link"><a href="$url_grupos">Grupos</a></li>
        <li class="link"><a href="$url_usuarios">Usuarios</a></li>
        <li class="link"><a href="$url_asignaciones">Asignaciones</a></li>
        <li class="link"><a href="$url_eventos">Eventos</a></li>
        <li class="link"><a href="$url_foros">Foros</a></li>
        <li class="link"><a href="$url_biblioteca">Biblioteca</a></li>

        HTML;

    }
} else {
    $url_secretaria = $app->getUrl() . '/secretaria/crear/';
    $url_eventos = $app->getUrl() . '/eventos/';
    $url_foros = $app->getUrl() . '/foros/';

    echo <<< HTML
    <li class="link"><a href="$url_secretaria">Contactar con Secretaría</a></li>
    <li class="link"><a href="$url_eventos">Eventos públicos</a></li>
    <li class="link"><a href="$url_foros">Foros públicos</a></li>

    HTML;
}

                    ?>
                </ul>
            </nav>
