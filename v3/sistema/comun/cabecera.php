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
use \Awsw\Gesi\Vistas\Vista;
use \Awsw\Gesi\Sesion;

$app = App::getSingleton();

?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?php echo Vista::getPaginaActualNombre(); ?> - Gesi</title>

		<link rel="stylesheet" href="<?php echo $app->getUrl(); ?>/css/estilos.css">
	</head>
	<body class="actual-<?php echo Vista::getPaginaActualId(); ?>">
		<div id="master-grid-wrapper">
			<header id="master-grid-header">
				<div id="app-logo">
					<img src="<?php echo $app->getUrl(); ?>/img/logo.svg" height="24" width="24" alt="Gesi">
				</div>

				<div id="app-name">
					<h1>Gesi</h1>
				</div>
			</header>

			<nav id="master-grid-user">
				<ul>
					<?php

if (Sesion::isSesionIniciada()) {

	$nombre = Sesion::getUsuarioEnSesion()->getNombreCompleto();
	$url_editar = $app->getUrl() . '/sesion/perfil/';
	$url_cerrar = $app->getUrl() . '/sesion/cerrar/';
		
					echo <<< HTML
					<li><a href="$url_editar">$nombre</a></li>
					<li><a href="$url_cerrar">Cerrar sesión</a></li>

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
					<li><a href="$url_inicio">Inicio</a></li>

HTML;

if (Sesion::isSesionIniciada()) {
	if (Sesion::getUsuarioEnSesion()->isEst()) {

		$url_mensajes = $app->getUrl() . '/mi/secretaria/';
		$url_asignaturas = $app->getUrl() . '/mi/asignaturas/';
		$url_horarios = $app->getUrl() . '/mi/horarios/';
		$url_eventos = $app->getUrl() . '/mi/eventos/';
		$url_foros = $app->getUrl() . '/mi/foros/';
		$url_biblioteca = $app->getUrl() . '/mi/biblioteca/';

						echo <<< HTML
					<li><a href="$url_mensajes">Mensajes de Secretaría</a></li>
					<li><a href="$url_asignaturas">Asignaturas</a></li>
					<li><a href="$url_horarios">Horarios</a></li>
					<li><a href="$url_eventos">Eventos</a></li>
					<li><a href="$url_foros">Foros</a></li>
					<li><a href="$url_biblioteca">Biblioteca</a></li>
					
HTML;

	} elseif (Sesion::getUsuarioEnSesion()->isPd()) {

		$url_mensajes = $app->getUrl() . '/mi/secretaria/';
		$url_asignaturas = $app->getUrl() . '/mi/asignaturas/';
		$url_grupos = $app->getUrl() . '/mi/grupos/';
		$url_asignaciones = $app->getUrl() . '/mi/asignaciones/';
		$url_horarios = $app->getUrl() . '/mi/horarios/';
		$url_eventos = $app->getUrl() . '/mi/eventos/';
		$url_foros = $app->getUrl() . '/mi/foros/';
		$url_biblioteca = $app->getUrl() . '/mi/biblioteca/';

						echo <<< HTML
					<li><a href="$url_mensajes">Mensajes de Secretaría</a></li>
					<li><a href="$url_asignaturas">Asignaturas</a></li>
					<li><a href="$url_grupos">Grupos</a></li>
					<li><a href="$url_asignaciones">Asignaciones</a></li>
					<li><a href="$url_horarios">Horarios</a></li>
					<li><a href="$url_eventos">Eventos</a></li>
					<li><a href="$url_foros">Foros</a></li>
					<li><a href="$url_biblioteca">Biblioteca</a></li>

HTML;
	
	} elseif (Sesion::getUsuarioEnSesion()->isPs()) {

		$url_mensajes = $app->getUrl() . '/admin/secretaria/';
		$url_asignaturas = $app->getUrl() . '/admin/asignaturas/';
		$url_grupos = $app->getUrl() . '/admin/grupos/';
		$url_usuarios = $app->getUrl() . '/admin/usuarios/';
		$url_asignaciones = $app->getUrl() . '/admin/asignaciones/';
		$url_horarios = $app->getUrl() . '/admin/horarios/';
		$url_eventos = $app->getUrl() . '/admin/eventos/';
		$url_foros = $app->getUrl() . '/admin/foros/';
		$url_biblioteca = $app->getUrl() . '/admin/biblioteca/';

						echo <<< HTML
					<li><a href="$url_mensajes">Mensajes de Secretaría</a></li>
					<li><a href="$url_asignaturas">Asignaturas</a></li>
					<li><a href="$url_grupos">Grupos</a></li>
					<li><a href="$url_usuarios">Usuarios</a></li>
					<li><a href="$url_asignaciones">Asignaciones</a></li>
					<li><a href="$url_horarios">Horarios</a></li>
					<li><a href="$url_eventos">Eventos</a></li>
					<li><a href="$url_foros">Foros</a></li>
					<li><a href="$url_biblioteca">Biblioteca</a></li>

HTML;

	}
}

					?>
				</ul>
			</nav>
