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
 * @version 0.0.4
 */

use Awsw\Gesi\App;
use Awsw\Gesi\Formularios\Sesion\Cerrar as FormularioSesionCerrar;
use Awsw\Gesi\Vistas\Vista;
use Awsw\Gesi\Sesion;

$app = App::getSingleton();

$v = (! $app->isDesarrollo()) ? '' : '?v=0.0.0' . time();

$formulario_logout = new FormularioSesionCerrar('');
$formulario_logout->gestiona();

$paginaActualNombre = Vista::getPaginaActualNombre();
$urlInicio = $app->getUrl();
$paginaActualId = Vista::getPaginaActualId();

$sideMenuBuffer = '';

// Generar elementos de navegación del menú lateral.

$sideMenuBuffer .= Vista::generarSideMenuLink('', 'Inicio', 'inicio');

if (Sesion::isSesionIniciada()) {
    $sideMenuBuffer .= Vista::generarSideMenuDivider('Acciones personales');

    $sideMenuBuffer .= Vista::generarSideMenuLink(
        '/ses/secretaria/', 'Mensajes de Secretaría', 'mensaje-secretaria-lista');
    $sideMenuBuffer .= Vista::generarSideMenuLink(
        '/ses/eventos/', 'Eventos', 'evento-lista');
    $sideMenuBuffer .= Vista::generarSideMenuLink(
        '/ses/foros/', 'Foros', 'foro-lista');
    $sideMenuBuffer .= Vista::generarSideMenuLink(
        '/ses/biblioteca/', 'Biblioteca', 'mi-biblioteca');

    if (Sesion::getUsuarioEnSesion()->isEst()) {
        $sideMenuBuffer .= Vista::generarSideMenuDivider(
            'Acciones de estudiantes');

        $sideMenuBuffer .= Vista::generarSideMenuLink(
            '/est/asignaturas/', 'Asignaturas', '');
        $sideMenuBuffer .= Vista::generarSideMenuLink(
            '/est/asignaciones/horario/', 'Horarios', '');
    } elseif (Sesion::getUsuarioEnSesion()->isPd()) {
        $sideMenuBuffer .= Vista::generarSideMenuDivider(
            'Acciones de personal docente');

        $sideMenuBuffer .= Vista::generarSideMenuLink(
            '/pd/asignaturas/', 'Asignaturas', '');
        $sideMenuBuffer .= Vista::generarSideMenuLink(
            '/pd/asignaciones/horario/', 'Horarios', '');
        $sideMenuBuffer .= Vista::generarSideMenuLink(
            '/pd/grupos/', 'Grupos', '');
        $sideMenuBuffer .= Vista::generarSideMenuLink(
            '/pd/asignaciones/', 'Asignaciones', '');
    } elseif (Sesion::getUsuarioEnSesion()->isPs()) {
        $sideMenuBuffer .= Vista::generarSideMenuDivider(
            'Acciones de administración');

        $sideMenuBuffer .= Vista::generarSideMenuLink(
            '/ps/secretaria/', 'Mensajes de Secretaría', '');
        $sideMenuBuffer .= Vista::generarSideMenuLink(
            '/ps/asignaturas/', 'Asignaturas', '');
        $sideMenuBuffer .= Vista::generarSideMenuLink(
            '/ps/grupos/', 'Grupos', '');
        $sideMenuBuffer .= Vista::generarSideMenuLink(
            '/ps/usuarios/', 'Usuarios', 'usuario-ps-list');
        $sideMenuBuffer .= Vista::generarSideMenuLink(
            '/ps/asignaciones/', 'Asignaciones', '');
        $sideMenuBuffer .= Vista::generarSideMenuLink(
            '/ps/eventos/', 'Eventos', '');
        $sideMenuBuffer .= Vista::generarSideMenuLink(
            '/ps/foros/', 'Foros', '');
        $sideMenuBuffer .= Vista::generarSideMenuLink(
            '/ps/biblioteca/', 'Biblioteca', '');
    }
} else {
    $sideMenuBuffer .= Vista::generarSideMenuLink(
        '/inv/secretaria/', 'Contactar con Secretaría', 'mensaje-secretaria-inv-list');
    $sideMenuBuffer .= Vista::generarSideMenuLink(
        '/inv/eventos/', 'Eventos públicos', '');
    $sideMenuBuffer .= Vista::generarSideMenuLink(
        '/inv/foros/', 'Foros públicos', '');
}

// Generar elementos de la navegación del menú de sesión de usuario.

$userMenuBuffer = '';

if (Sesion::isSesionIniciada()) {
    $u = Sesion::getUsuarioEnSesion();

    $nombre = $u->getNombreCompleto();

    $url_editar = $urlInicio . '/sesion/perfil/';
    
    $badges = '';
    $badges .= $u->isEst() ? '<span class="badge">Estudiante</span>' : '';
    $badges .= $u->isPd() ? '<span class="badge">Personal docente</span>' : '';
    $badges .= $u->isPs() ? '<span class="badge">Personal de Secretaría</span>' : '';

    $formularioLogoutHtml = $formulario_logout->getHtml();

    $userMenuBuffer .= Vista::generarUserMenuItem("<a class=\"nav-link\" href=\"$url_editar\">$nombre $badges</a>", 'mi-perfil');
    $userMenuBuffer .= Vista::generarUserMenuItem($formularioLogoutHtml);
} else {
    $url = $urlInicio . '/sesion/iniciar/';

    $userMenuBuffer .= Vista::generarUserMenuItem("<a class=\"nav-link\" href=\"$url\">Iniciar sesión</a>", 'sesion-iniciar');
}

// Generar HTML final de la cabecera.

$headerFinalHtmlBuffer = '';

$headerFinalHtmlBuffer .= <<< HTML
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="#7b1fa2">

        <title>$paginaActualNombre - Gesi</title>

        <!-- Fuentes -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:400,700&display=swap">

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <!-- Estilos de Gesi -->
        <link rel="stylesheet" href="$urlInicio/css/app.css$v">
    </head>
    <body class="actual-$paginaActualId">

        <div id="loading-progress-bar"><div></div></div>

        <div id="side-menu-wrapper">
            <div class="m-3">
                <button type="button" id="btn-side-menu-hide" class="btn btn-sm btn-outline-secondary mr-4">Cerrar</button>
            </div>

            <nav>
                <div class="list-group list-group-flush">
                    $sideMenuBuffer
                </div>
            </nav>
        </div>
            
        <nav id="main-header" class="navbar navbar-expand-lg navbar-light bg-light">
            <button type="button" id="btn-side-menu-show" class="btn btn-sm btn-outline-secondary mr-4">Menu</button>

            <a class=" navbar-brand" href="#">
                <img src="$urlInicio/img/logo.svg" height="30" alt="" class="d-block mr-3">
            </a>

            <div class="ml-auto">
                <ul class="navbar-nav">
                    $userMenuBuffer
                </ul>
            </div>
        </nav>
HTML;

echo $headerFinalHtmlBuffer;

?>