<?php

/**
 * Vista de movimientos personales en la biblioteca.
 *
 * - Registrados: pueden ver sus movimientos en la biblioteca.
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

Vista::setPaginaActual("Mis movimientos en la biblioteca", "biblioteca-movimientos");

Vista::incluirCabecera();

?>
<div class="wrapper">
	<div class="container">
		<header class="page-header">
			<h1>Mis movimientos en la biblioteca</h1>
		</header>

		<section class="page-content">
			...
		</section>
	</div>
</div>
<?php

Vista::incluirPie();
