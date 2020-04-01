<?php

/**
 * Vista de landing.
 *
 * Invitados: verán información de acceso público.
 * Usuarios registrados: verán información personalizada.
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

require_once __DIR__ . "/sistema/configuracion.php";

use \Awsw\Gesi\Vistas\Vista;

Vista::setPaginaActual("Inicio", "home");

Vista::incluirCabecera();

?>
<div class="wrapper">
	<div class="container">
		<header class="page-header">
			<h1>Inicio</h1>
		</header>

		<section class="page-content">
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus iaculis fermentum lorem, et maximus sapien pulvinar at. In id leo nisl. Mauris consectetur ante ac nisl rhoncus mollis. Quisque ac est magna. Proin lacinia, elit id condimentum consequat, est ante sodales erat, non bibendum risus massa vitae arcu. Pellentesque porttitor, metus quis cursus tincidunt, velit metus vulputate est, in tempus metus odio sit amet metus. Aliquam nec laoreet turpis. Aenean felis arcu, efficitur nec dui non, tincidunt cursus turpis. Quisque egestas erat iaculis quam sodales dictum. Phasellus dui purus, aliquet non ex at, volutpat scelerisque enim.</p>

			<p>Aliquam auctor dui erat, vel cursus neque malesuada ut. Duis semper dui nec massa consequat feugiat. Aliquam varius nibh at nulla tristique fringilla. Mauris nisi ipsum, malesuada vel lectus quis, tincidunt ullamcorper nulla. Aenean blandit volutpat orci sed cursus. Duis ac molestie dolor. Etiam feugiat enim sed venenatis tempus.</p>

			<p>Nam ultricies tristique metus, id sagittis ligula posuere a. Proin facilisis nibh felis, vitae porta lorem congue nec. In condimentum pharetra magna id sollicitudin. Quisque a diam sem. Curabitur fringilla porta lectus et gravida. Proin rhoncus vulputate quam, ut molestie magna tincidunt sed. Etiam lacinia mattis leo. Praesent eget risus eros. Nulla sed augue iaculis, tincidunt lacus vitae, pellentesque metus. Phasellus cursus suscipit ante, in laoreet sem venenatis ac. Nulla facilisi. Aenean ipsum sapien, lacinia a egestas eget, consectetur nec turpis. Aenean non dapibus erat. Donec accumsan lobortis fringilla. Proin magna risus, vulputate et urna ac, convallis bibendum augue. Cras eget viverra elit, eget blandit libero.</p>

			<p>Nunc varius nibh et facilisis fermentum. Vestibulum eu facilisis nulla. Cras non dignissim velit, et tincidunt leo. Maecenas fringilla, risus eget sollicitudin fringilla, enim ante imperdiet arcu, sed lobortis urna nibh a leo. In tristique tristique urna quis luctus. Sed commodo sit amet eros ut sagittis. Quisque congue tortor dui, in ornare odio mollis eget. Nam sit amet pharetra quam, dictum fermentum risus. In sollicitudin libero et nibh vestibulum tincidunt. Suspendisse augue felis, pulvinar at scelerisque non, ultricies eget purus. Nullam id metus in diam faucibus pulvinar ac sed sem. Vivamus quis dapibus mi. Ut tempus leo vitae imperdiet mollis. Quisque sodales dui vitae dui tempus dictum. Donec rutrum ultricies lectus sodales consectetur. Nunc consectetur, velit non interdum iaculis, dolor quam accumsan lacus, nec fringilla velit ante eu sapien.</p>
		</section>
	</div>
</div>
<?php

Vista::incluirPie();