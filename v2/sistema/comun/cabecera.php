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

?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?php echo Vista::getPaginaActualNombre(); ?> - Gesi</title>

		<link rel="stylesheet" href="<?php echo App::getSingleton()->getUrl(); ?>/css/estilos.css">
	</head>
	<body>
		<div id="main-header-background">
			<div class="wrapper">
				<header id="main-header" class="container">
					<div class="float-left">
						<div id="app-logo">
							<img src="<?php echo App::getSingleton()->getUrl(); ?>/img/logo.svg" height="32" width="32" alt="Gesi">
						</div>

						<div id="app-name">
							<h1>Gesi</h1>
						</div>

						<nav id="main-menu">
							<p class="screen-reader-text">Menú principal</p>

							<ul>
								<li><a href="./">Inicio</a></li>
							</ul>
						</nav>
					</div>

					<div class="float-right">
						<nav id="user-menu">
							<p class="screen-reader-text">Menú de usuario</p>

							<ul>
								<?php

if (Sesion::isLogged()) {
					
								?><li><?php echo Sesion::getLoggedInUser()->getNombre(); ?></li>
								<li><a href="logout.php">Cerrar sesión</a></li><?php

} else {
	
								?><li><a href="login.php">Iniciar sesión</a></li><?php

}

								?>
							</ul>
						</nav>
					</div>
					
					<div class="clearfix"></div>
				</header>
			</div>
		</div>